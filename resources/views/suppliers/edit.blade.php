<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>

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

        a {
            color: #16735b;
        }

        .errors {
            color: #991b1b;
        }
    </style>
</head>
<body>
    <h1>Edit Supplier</h1>
    <a href="{{ route('suppliers.index') }}">Kembali ke daftar supplier</a>

    @if ($errors->any())
        <ul class="errors">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nama supplier:</label>
        <input
            id="name"
            name="name"
            value="{{ old('name', $supplier->name) }}"
            required
        >

        <label for="contact_person">Nama kontak:</label>
        <input
            id="contact_person"
            name="contact_person"
            value="{{ old('contact_person', $supplier->contact_person) }}"
        >

        <label for="phone">Nomor telepon:</label>
        <input
            id="phone"
            name="phone"
            value="{{ old('phone', $supplier->phone) }}"
        >

        <label for="email">Email:</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email', $supplier->email) }}"
        >

        <label for="address">Alamat:</label>
        <textarea id="address" name="address">{{ old('address', $supplier->address) }}</textarea>

        <button type="submit">Simpan perubahan</button>
    </form>
</body>
</html>