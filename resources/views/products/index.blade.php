<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Produk</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 32px;
            color: #243447;
            background: #f3f6f8;
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 1100px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 8px;
            color: #174c3c;
        }

        h2 {
            margin-top: 28px;
            color: #315d50;
        }

        .subtitle {
            margin-top: 0;
            color: #64748b;
        }

        form {
            margin: 16px 0;
            padding: 20px;
            background: white;
            border: 1px solid #e1e8ec;
            border-radius: 10px;
        }

        input,
        select,
        textarea,
        button {
            padding: 10px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        input:not([type="checkbox"]),
        select,
        textarea {
            display: block;
            width: 100%;
            max-width: 420px;
            margin-top: 6px;
        }

        input[type="checkbox"] {
            width: auto;
            margin-right: 6px;
        }

        textarea {
            min-height: 80px;
        }

        button {
            color: white;
            background: #176b55;
            border: 0;
            cursor: pointer;
        }

        button:hover {
            background: #105440;
        }

        a {
            color: #16735b;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .supplier-option {
            display: block;
            margin-top: 8px;
        }

        .table-wrap {
            overflow-x: auto;
            margin-top: 24px;
            background: white;
            border: 1px solid #e1e8ec;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #e6ecef;
            text-align: left;
            white-space: nowrap;
        }

        th {
            color: white;
            background: #22634f;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 13px;
        }

        .low {
            color: #991b1b;
            background: #fee2e2;
        }

        .safe {
            color: #166534;
            background: #dcfce7;
        }

        .empty {
            padding: 24px;
            color: #64748b;
            text-align: center;
        }

        .success {
            color: #166534;
        }

        .errors {
            color: #991b1b;
        }

        @media (max-width: 600px) {
            body {
                padding: 18px 12px;
            }

            form {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <main>
        <h1>Daftar Produk</h1>
        <p class="subtitle">Informasi produk dan kondisi stok inventaris.</p>

        <p> 
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('categories.index') }}">Kelola kategori</a> |
                <a href="{{ route('suppliers.index') }}">Kelola supplier</a> |
                <a href="{{ route('users.index') }}">Kelola staff</a> |
            @endif
            <a href="{{ route('stock-movements.index') }}">Barang masuk/keluar</a>
        </p>

        <p>
            Login sebagai <strong>{{ auth()->user()->name }}</strong>
            ({{ auth()->user()->role }})
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        

        @if (auth()->user()->role === 'admin')
            <h2>Tambah kategori</h2>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <label for="category-name">Nama kategori:</label>
                <input
                    id="category-name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Elektronik"
                    required
                >

                <br>
                <button type="submit">Simpan kategori</button>
            </form>

            <h2>Tambah produk</h2>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <p>
                    <label for="category_id">Kategori:</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">-- Pilih kategori --</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </p>

                <p>
                    <strong>Supplier:</strong>

                    @forelse ($suppliers as $supplier)
                        <label class="supplier-option">
                            <input
                                type="checkbox"
                                name="suppliers[]"
                                value="{{ $supplier->id }}"
                                @checked(in_array($supplier->id, old('suppliers', [])))
                            >
                            {{ $supplier->name }}
                        </label>
                    @empty
                        <br>
                        Belum ada supplier. Tambahkan supplier terlebih dahulu.
                    @endforelse
                </p>

                <p>
                    <label for="sku">SKU:</label>
                    <input
                        id="sku"
                        name="sku"
                        value="{{ old('sku') }}"
                        required
                    >
                </p>

                <p>
                    <label for="product-name">Nama produk:</label>
                    <input
                        id="product-name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                </p>

                <p>
                    <label for="price">Harga:</label>
                    <input
                        id="price"
                        type="number"
                        name="price"
                        min="0"
                        step="0.01"
                        value="{{ old('price') }}"
                        required
                    >
                </p>

                <p>
                    <label for="stock">Stok:</label>
                    <input
                        id="stock"
                        type="number"
                        name="stock"
                        min="0"
                        value="{{ old('stock', 0) }}"
                        required
                    >
                </p>

                <p>
                    <label for="minimum_stock">Batas minimum stok:</label>
                    <input
                        id="minimum_stock"
                        type="number"
                        name="minimum_stock"
                        min="0"
                        value="{{ old('minimum_stock', 5) }}"
                        required
                    >
                </p>

                <button type="submit">Simpan produk</button>
            </form>

            <h2>Tambah supplier</h2>

            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf

                <p>
                    <label for="supplier-name">Nama supplier:</label>
                    <input
                        id="supplier-name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                </p>

                <p>
                    <label for="contact_person">Nama kontak:</label>
                    <input
                        id="contact_person"
                        name="contact_person"
                        value="{{ old('contact_person') }}"
                    >
                </p>

                <p>
                    <label for="phone">Nomor telepon:</label>
                    <input
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                    >
                </p>

                <p>
                    <label for="email">Email:</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                    >
                </p>

                <p>
                    <label for="address">Alamat:</label>
                    <textarea id="address" name="address">{{ old('address') }}</textarea>
                </p>

                <button type="submit">Simpan supplier</button>
            </form>
        @endif

        <h2>Daftar produk</h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status stok</th>
                        <th>Supplier</th>

                        @if (auth()->user()->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if ($product->stock <= $product->minimum_stock)
                                    <span class="badge low">Stok rendah</span>
                                @else
                                    <span class="badge safe">Aman</span>
                                @endif
                            </td>
                            <td>
                                @forelse ($product->suppliers as $supplier)
                                    {{ $supplier->name }}@if (!$loop->last), @endif
                                @empty
                                    Belum ada
                                @endforelse
                            </td>

                            @if (auth()->user()->role === 'admin')
                                <td>
                                    <a href="{{ route('products.edit', $product) }}">Edit</a>

                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        style="display: inline; padding: 0; border: 0;"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="empty"
                                colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}"
                            >
                                Belum ada produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>