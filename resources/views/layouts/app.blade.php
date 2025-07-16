<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Voz Popular')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
    @yield('head')
    <style>
    .nav-btn {
        background-color: #806060;
        border-radius: 6px;
        text-decoration: none;
        color: white;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background-color: #473d3dff;
        color: white;
        padding: 10px 12px;
        border-radius: 6px;
        cursor: pointer;
        border: none;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        left: 0;
        background-color: #473d3dff;
        overflow: hidden;
        z-index: 999;
        border: 4px solid #806060;
    }

    .dropdown:hover .dropdown-content,
    .dropdown-content:hover {
        display: block;
    }

    .dropdown-content a {
        color: white;
        padding: 10px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #5a4242;
    }

    .logout-button {
        background-color: #ff6b6b;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
</style>

</head>
<body>

<header style="display: flex; justify-content: space-between; align-items: center; padding: 8px 20px; background-color: #701a1a; border-radius: 0 0 10px 10px;">

    <!-- Avatar -->
    <div class="nav-left">
        <a href="{{ route('perfil') }}">
            <img src="{{ asset('images/avatar-placeholder.png') }}" width="45" height="45" style="border-radius: 50%;">
        </a>
    </div>

    <!-- Navegação Central -->
    <div class="nav-center" style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ url('/') }}" class="nav-btn">Home</a>

        <!-- Botão suspenso -->
        <div class="dropdown">
            <button class="dropdown-toggle">Ocorrências ▾</button>
            <div class="dropdown-content">
                <a href="{{ url('/galeria') }}">Todos</a>
                <a href="{{ url('/rejeitados') }}">Rejeitados</a>
                <a href="{{ url('/suspensos') }}">Suspensos</a>
            </div>
        </div>

        <a href="{{ url('/analise') }}" class="nav-btn">Em Análise</a>
        <a href="{{ url('/aguardando') }}" class="nav-btn">Aguardando Aprovação</a>
        <a href="{{ url('/andamento') }}" class="nav-btn">Em Andamento</a>
        <!-- Botão Logout -->
        <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding-left: 10px;">
            @csrf
            <button type="submit" class="logout-button">
                <img src="{{ asset('images/sair.png') }}" alt="Sair" style="width: 20px; height: 20px;">
            </button>
        </form>
    </div>

    <!-- Logo e título -->
    <div class="nav-left" style="display: flex; align-items: center; gap: 10px;">
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
