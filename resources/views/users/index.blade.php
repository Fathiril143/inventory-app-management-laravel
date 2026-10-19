<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Akun Staff</title>

    <style>
        body {
            max-width: 950px;
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
        button,
        a.button {
            padding: 9px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        input {
            width: 100%;
            max-width: 420px;
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
    <h1>Kelola Akun Staff</h1>

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

    <h2>Tambah staff</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <label for="name">Nama staff:</label>
        <input id="name" name="name" value="{{ old('name') }}" required>

        <label for="email">Email untuk login:</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
        >

        <label for="password">Password (minimal 8 karakter):</label>
        <input id="password" type="password" name="password" required>

        <label for="password_confirmation">Ulangi password:</label>
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            required
        >

        <button type="submit">Buat akun staff</button>
    </form>

    <h2>Daftar staff</h2>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staff as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>Staff</td>
                        <td>
                            <a
                                class="button"
                                href="{{ route('users.edit', $user) }}"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('users.destroy', $user) }}"
                                method="POST"
                                style="display: inline; padding: 0; border: 0;"
                                onsubmit="return confirm('Yakin ingin menghapus akun staff ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada akun staff.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>