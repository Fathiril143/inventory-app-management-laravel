<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan Stok</title>

    <style>
        body {
            max-width: 700px;
            margin: 35px auto;
            padding: 0 18px;
            color: #243447;
            background: #f3f6f8;
            font-family: Arial, sans-serif;
        }

        form {
            margin-top: 20px;
            padding: 22px;
            background: white;
            border: 1px solid #e1e8ec;
            border-radius: 10px;
        }

        label {
            display: block;
            margin: 14px 0 6px;
        }

        input,
        select,
        textarea,
        button {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        textarea {
            min-height: 90px;
        }

        button {
            margin-top: 18px;
            color: white;
            background: #176b55;
            border: 0;
            cursor: pointer;
        }

        .errors {
            color: #991b1b;
        }

        a {
            color: #16735b;
        }
    </style>
</head>
<body>
    <h1>Edit catatan stok</h1>
    <a href="{{ route('stock-movements.index') }}">Kembali ke daftar catatan</a>

    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form
        action="{{ route('stock-movements.update', $stockMovement) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <label for="product_id">Produk:</label>
        <select id="product_id" name="product_id" required>
            @foreach ($products as $product)
                <option
                    value="{{ $product->id }}"
                    @selected(old('product_id', $stockMovement->product_id) == $product->id)
                >
                    {{ $product->name }} (stok saat ini: {{ $product->stock }})
                </option>
            @endforeach
        </select>

        <label for="type">Jenis transaksi:</label>
        <select id="type" name="type" required>
            <option
                value="in"
                @selected(old('type', $stockMovement->type) === 'in')
            >
                Barang masuk
            </option>
            <option
                value="out"
                @selected(old('type', $stockMovement->type) === 'out')
            >
                Barang keluar
            </option>
        </select>

        <label for="quantity">Jumlah:</label>
        <input
            id="quantity"
            type="number"
            name="quantity"
            min="1"
            value="{{ old('quantity', $stockMovement->quantity) }}"
            required
        >

        <label for="note">Catatan (boleh dikosongkan):</label>
        <textarea id="note" name="note">{{ old('note', $stockMovement->note) }}</textarea>

        <button type="submit">Simpan perubahan</button>
    </form>
</body>
</html>