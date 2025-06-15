<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Voz Popular')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    @yield('head')
</head>
<body>

    <header style="display: flex; justify-content: flex-end;">

<div style="display: flex; justify-content: flex-end;">
    <div style="display: flex; gap: 10px; align-items: center;">
        <span style="font-weight: bold; font-size: 18px; text-align: right;">VOZ<br>POPULAR</span>
        <img src="{{ asset('images/logo-prefeitura.png') }}" alt="Logo" height="50">
    </div>
</div>


    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        © {{ date('Y') }} IFMS + Prefeitura de Ladário
    </footer>

</body>
</html>
