<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with(['category', 'suppliers'])
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.index', compact(
            'products',
            'categories',
            'suppliers'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);
        $supplierIds = $validated['suppliers'] ?? [];
        unset($validated['suppliers']);

        DB::transaction(function () use ($validated, $supplierIds) {
            $product = Product::create($validated);
            $product->suppliers()->sync($supplierIds);
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $product->load('suppliers');

        return view('products.edit', compact(
            'product',
            'categories',
            'suppliers'
        ));
    }

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $this->validateProduct($request, $product);
        $supplierIds = $validated['suppliers'] ?? [];
        unset($validated['suppliers']);

        DB::transaction(function () use (
            $validated,
            $supplierIds,
            $product
        ) {
            $product->update($validated);
            $product->suppliers()->sync($supplierIds);
        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->stockMovements()->exists()) {
            return back()->withErrors([
                'product' => 'Produk memiliki riwayat stok, jadi tidak bisa dihapus.',
            ]);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function validateProduct(
        Request $request,
        ?Product $product = null
    ): array {
        $skuRule = 'unique:products,sku';

        if ($product) {
            $skuRule .= ',' . $product->id;
        }

        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:255', $skuRule],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'suppliers' => ['nullable', 'array'],
            'suppliers.*' => ['integer', 'exists:suppliers,id'],
        ]);
    }
}