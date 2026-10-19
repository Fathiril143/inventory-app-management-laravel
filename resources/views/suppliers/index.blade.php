<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Supplier</title>

    <style>
        body {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 16px;
            color: #243447;
            background: #f3f6f8;
            font-family: Arial, sans-serif;
        }

        form,
        .table-wrap {
            margin-top: 18px;
            padding: 18px;
            background: white;
            border: 1px solid #e1e8ec;
            border-radius: 10px;
        }

        label {
            display: block;
            margin: 12px 0 6px;
        }

        input,
        textarea,
        button,
        a.button {
            padding: 9px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        input,
        textarea {
            width: 100%;
            max-width: 420px;
        }

        textarea {
            min-height: 70px;
        }

        button,
        a.button {
            display: inline-block;
            margin-top: 10px;
            color: white;
            background: #176b55;
            border: 0;
            text-decoration: none;
            cursor: pointer;
        }

        .delete {
            background: #b42318;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e6ecef;
            text-align: left;
        }

        th {
            color: white;
            background: #22634f;
        }

        .success {
            color: #166534;
        }

        .errors {
            color: #991b1b;
        }
    </style>
</head>
<body>
    <h1>Kelola Supplier</h1>

    <p>
        <a class="button" href="{{ route('products.index') }}">Kembali ke produk</a>
    </p>

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

    <h2>Tambah supplier</h2>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        <label for="name">Nama supplier:</label>
        <input id="name" name="name" value="{{ old('name') }}" required>

        <label for="contact_person">Nama kontak:</label>
        <input
            id="contact_person"
            name="contact_person"
            value="{{ old('contact_person') }}"
        >

        <label for="phone">Nomor telepon:</label>
        <input id="phone" name="phone" value="{{ old('phone') }}">

        <label for="email">Email:</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
        >

        <label for="address">Alamat:</label>
        <textarea id="address" name="address">{{ old('address') }}</textarea>

        <br>
        <button type="submit">Simpan supplier</button>
    </form>

    <h2>Daftar supplier</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Jumlah produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact_person ?: '-' }}</td>
                        <td>{{ $supplier->phone ?: '-' }}</td>
                        <td>{{ $supplier->email ?: '-' }}</td>
                        <td>{{ $supplier->products_count }}</td>
                        <td>
                            <a
                                class="button"
                                href="{{ route('suppliers.edit', $supplier) }}"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('suppliers.destroy', $supplier) }}"
                                method="POST"
                                style="display: inline; padding: 0; border: 0;"
                                onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>