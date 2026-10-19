<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>

    <style>
        body {
            max-width: 900px;
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

        input,
        button,
        a.button {
            padding: 9px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        button,
        a.button {
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

        .errors {
            color: #991b1b;
        }

        .success {
            color: #166534;
        }
    </style>
</head>
<body>
    <h1>Kelola Kategori</h1>

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

    <h2>Tambah kategori</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <label for="name">Nama kategori:</label>
        <input
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Contoh: Elektronik"
            required
        >

        <button type="submit">Simpan</button>
    </form>

    <h2>Daftar kategori</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama kategori</th>
                    <th>Jumlah produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <a
                                class="button"
                                href="{{ route('categories.edit', $category) }}"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('categories.destroy', $category) }}"
                                method="POST"
                                style="display: inline; padding: 0; border: 0;"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>