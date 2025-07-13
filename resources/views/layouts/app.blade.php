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

    <header>
        <div class="nav-left">
            <a href="{{ url('/perfil') }}">
    <img src="{{ asset('images/avatar-placeholder.png') }}" width="45" height="45" style="border-radius: 50%;">
</a>

            
        </div>

        <div class="nav-center">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ url('/galeria') }}">Galeria</a>
                <a href="{{ url('/rejeitados') }}">Rejeitados</a>
                <a href="{{ url('/analise') }}">Em Análise</a>
        </div>

        <div class="nav-right">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-weight: bold; font-size: 18px;">VOZ<br>POPULAR</span>
                <img src="{{ asset('images/logo-prefeitura.png') }}" alt="Logo" height="50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:red;">Sair</button>
                </form>
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
