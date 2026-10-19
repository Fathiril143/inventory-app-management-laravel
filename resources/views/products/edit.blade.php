<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>

    <style>
        body {
            max-width: 700px;
            margin: 35px auto;
            padding: 0 16px;
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

        input[type="checkbox"] {
            width: auto;
        }

        textarea {
            min-height: 80px;
        }

        button {
            margin-top: 18px;
            color: white;
            background: #176b55;
            border: 0;
            cursor: pointer;
        }

        a {
            color: #16735b;
        }

        .errors {
            color: #991b1b;
        }

        .supplier-option {
            display: block;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <h1>Edit Produk</h1>
    <a href="{{ route('products.index') }}">Kembali ke daftar produk</a>

    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="category_id">Kategori:</label>
        <select id="category_id" name="category_id" required>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id) == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Supplier:</label>
        @foreach ($suppliers as $supplier)
            <label class="supplier-option">
                <input
                    type="checkbox"
                    name="suppliers[]"
                    value="{{ $supplier->id }}"
                    @checked(
                        in_array(
                            $supplier->id,
                            old('suppliers', $product->suppliers->pluck('id')->all())
                        )
                    )
                >
                {{ $supplier->name }}
            </label>
        @endforeach

        <label for="sku">SKU:</label>
        <input
            id="sku"
            name="sku"
            value="{{ old('sku', $product->sku) }}"
            required
        >

        <label for="name">Nama produk:</label>
        <input
            id="name"
            name="name"
            value="{{ old('name', $product->name) }}"
            required
        >

        <label for="price">Harga:</label>
        <input
            id="price"
            type="number"
            name="price"
            min="0"
            step="0.01"
            value="{{ old('price', $product->price) }}"
            required
        >

        <label for="stock">Stok:</label>
        <input
            id="stock"
            type="number"
            name="stock"
            min="0"
            value="{{ old('stock', $product->stock) }}"
            required
        >

        <label for="minimum_stock">Batas minimum stok:</label>
        <input
            id="minimum_stock"
            type="number"
            name="minimum_stock"
            min="0"
            value="{{ old('minimum_stock', $product->minimum_stock) }}"
            required
        >

        <button type="submit">Simpan perubahan</button>
    </form>
</body>
</html>