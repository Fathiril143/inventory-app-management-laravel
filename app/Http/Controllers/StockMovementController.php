<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function index(): View
    {
        $movements = StockMovement::with('product')
            ->latest()
            ->get();

        return view('stock-movements.index', compact('movements'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();

        return view('stock-movements.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($data) {
            $product = Product::whereKey($data['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $this->applyStockChange(
                $product,
                $data['type'],
                (int) $data['quantity']
            );

            StockMovement::create($data);
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Catatan stok berhasil ditambahkan.');
    }

    public function show(StockMovement $stockMovement): RedirectResponse
    {
        return redirect()->route('stock-movements.index');
    }

    public function edit(StockMovement $stockMovement): View
    {
        $products = Product::orderBy('name')->get();

        return view('stock-movements.edit', compact(
            'stockMovement',
            'products'
        ));
    }

    public function update(
        Request $request,
        StockMovement $stockMovement
    ): RedirectResponse {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($data, $stockMovement) {
            $movement = StockMovement::whereKey($stockMovement->id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldProduct = Product::whereKey($movement->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            $newProduct = (int) $data['product_id'] === (int) $oldProduct->id
                ? $oldProduct
                : Product::whereKey($data['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

            $this->reverseStockChange($oldProduct, $movement);

            $this->applyStockChange(
                $newProduct,
                $data['type'],
                (int) $data['quantity']
            );

            $movement->update($data);
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Catatan stok berhasil diperbarui.');
    }

    public function destroy(StockMovement $stockMovement): RedirectResponse
    {
        DB::transaction(function () use ($stockMovement) {
            $movement = StockMovement::whereKey($stockMovement->id)
                ->lockForUpdate()
                ->firstOrFail();

            $product = Product::whereKey($movement->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->reverseStockChange($product, $movement);

            $movement->delete();
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Catatan stok berhasil dihapus.');
    }

    private function applyStockChange(
        Product $product,
        string $type,
        int $quantity
    ): void {
        if ($type === 'out' && $product->stock < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Stok tidak cukup untuk barang keluar.',
            ]);
        }

        $product->stock += $type === 'in' ? $quantity : -$quantity;
        $product->save();
    }

    private function reverseStockChange(
        Product $product,
        StockMovement $movement
    ): void {
        if ($movement->type === 'in' && $product->stock < $movement->quantity) {
            throw ValidationException::withMessages([
                'movement' => 'Catatan tidak bisa diubah atau dihapus karena stoknya sudah terpakai.',
            ]);
        }

        $product->stock += $movement->type === 'in'
            ? -$movement->quantity
            : $movement->quantity;

        $product->save();
    }
}