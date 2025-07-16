@extends('layouts.loginlayout')

@section('title', 'Login')

@section('content')

    <div class="login-container">


        @if(session('error'))
            <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2>VOZ<br>POPULAR</h2>
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="senha" required>
            <label>
                <input type="checkbox" name="remember"> manter conectado
            </label><br><br>
            <button type="submit">Entrar</button>
        </form>
    </div>

@endsection
