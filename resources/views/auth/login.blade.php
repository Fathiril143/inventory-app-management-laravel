<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Inventaris</title>

    <style>
        body {
            display: grid;
            min-height: 100vh;
            place-items: center;
            margin: 0;
            padding: 20px;
            color: #243447;
            background: #f3f6f8;
            font-family: Arial, sans-serif;
        }

        main {
            width: 100%;
            max-width: 420px;
            padding: 28px;
            background: white;
            border: 1px solid #e1e8ec;
            border-radius: 12px;
        }

        h1 {
            margin-top: 0;
            color: #174c3c;
        }

        label {
            display: block;
            margin: 16px 0 6px;
        }

        input,
        button {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #cbd5dc;
            border-radius: 6px;
            font: inherit;
        }

        button {
            margin-top: 20px;
            color: white;
            background: #176b55;
            border: 0;
            cursor: pointer;
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
    <main>
        <h1>Login Inventaris</h1>

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

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <label for="email">Email:</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >

            <label for="password">Password:</label>
            <input
                id="password"
                type="password"
                name="password"
                required
            >

            <button type="submit">Masuk</button>
        </form>
    </main>
</body>
</html>