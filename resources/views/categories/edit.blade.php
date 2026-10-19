<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>

    <style>
        body {
            max-width: 650px;
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
            margin-bottom: 8px;
        }

        input,
        button {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        button {
            margin-top: 16px;
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
    </style>
</head>
<body>
    <h1>Edit Kategori</h1>
    <a href="{{ route('categories.index') }}">Kembali ke daftar kategori</a>

    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nama kategori:</label>
        <input
            id="name"
            name="name"
            value="{{ old('name', $category->name) }}"
            required
        >

        <button type="submit">Simpan perubahan</button>
    </form>
</body>
</html>