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

<header style="display: flex; justify-content: space-between; align-items: center; padding: 8px 20px; background-color: #701a1a; border-radius: 0 0 10px 10px;">

    <!-- Avatar -->
    <div class="nav-left">
        <img src="{{ asset('images/avatar-placeholder.png') }}" width="45" height="45" style="border-radius: 50%;">
    </div>

    <!-- Navegação Central -->
    <div  class="nav-center"style="display: flex; gap: 20px;">
        <a href="{{ url('/') }}" class="nav-btn">Home</a>
        <a href="{{ url('/galeria') }}" class="nav-btn">Galeria</a>
        <a href="{{ url('/rejeitados') }}" class="nav-btn">Rejeitados</a>
        <a href="{{ url('/analise') }}" class="nav-btn">Em Análise</a>

        <!-- Botão Logout com ícone -->
        <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding-left: 10px;">
            @csrf
            <button type="submit" style="background-color: #ff6b6b; border: none; border-radius: 6px; padding: 6px; cursor: pointer;">
                <img src="{{ asset('images/sair.png') }}" alt="Sair" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <!-- Logo e título -->
    <div class="nav-left"style="display: flex; align-items: center; gap: 10px;">
        <span style="font-weight: bold; font-size: 18px;">VOZ<br>POPULAR</span>
        <img src="{{ asset('images/logo-prefeitura.png') }}" alt="Logo" height="50">
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
