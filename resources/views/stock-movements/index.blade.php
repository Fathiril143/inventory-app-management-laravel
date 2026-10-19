<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk dan Keluar</title>

    <style>
        body {
            margin: 0;
            padding: 30px;
            color: #243447;
            background: #f3f6f8;
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            color: #174c3c;
        }

        a,
        button {
            display: inline-block;
            margin: 4px;
            padding: 9px 12px;
            border: 0;
            border-radius: 6px;
            color: white;
            background: #176b55;
            text-decoration: none;
            cursor: pointer;
            font: inherit;
        }

        .delete {
            background: #b42318;
        }

        .table-wrap {
            overflow-x: auto;
            margin-top: 20px;
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

        .empty {
            padding: 20px;
            color: #64748b;
            text-align: center;
        }
    </style>
</head>
<body>
    <main>
        <h1>Barang Masuk dan Keluar</h1>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <a href="{{ route('products.index') }}">Kembali ke produk</a>
        <a href="{{ route('stock-movements.create') }}">Tambah catatan stok</a>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $movement->product->name }}</td>
                            <td>
                                {{ $movement->type === 'in' ? 'Barang masuk' : 'Barang keluar' }}
                            </td>
                            <td>{{ $movement->quantity }}</td>
                            <td>{{ $movement->note ?: '-' }}</td>
                            <td>
                                <a href="{{ route('stock-movements.edit', $movement) }}">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('stock-movements.destroy', $movement) }}"
                                    method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Yakin ingin menghapus catatan ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="empty" colspan="6">
                                Belum ada catatan barang masuk atau keluar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>