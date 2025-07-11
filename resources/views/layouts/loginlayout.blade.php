<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Voz Popular')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #650000;
            padding: 10px 20px;
            display: flex;
            justify-content: center;
        }

        header img {
            height: 60px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #650000;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
        }

        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .login-container form {
            border: 2px dashed #650000;
            padding: 30px;
            border-radius: 30px;
            width: 100%;
            max-width: 400px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #650000;
            border-radius: 8px;
            font-weight: bold;
        }

        .login-container label {
            display: inline-block;
            margin-top: 10px;
        }

        .login-container button {
            margin-top: 20px;
            background-color: #d9534f;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .login-container button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ asset('images/logo-prefeitura.png') }}" alt="Logo Prefeitura">
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        © {{ date('Y') }} IFMS + Prefeitura de Ladário
    </footer>

</body>
</html>
