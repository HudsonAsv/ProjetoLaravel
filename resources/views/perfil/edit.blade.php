@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
    <h2>Editar Perfil</h2>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('perfil.update') }}">
        @csrf

        <label>Nome:</label><br>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required><br><br>

        <label>Bio:</label><br>
        <textarea name="bio">{{ old('bio', $user->bio) }}</textarea><br><br>

        <label>Tipo de conta:</label><br>
        <select name="role" required>
            <option value="padrao" {{ $user->role == 'padrao' ? 'selected' : '' }}>Padrão</option>
            <option value="auxiliar" {{ $user->role == 'auxiliar' ? 'selected' : '' }}>Auxiliar</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
        </select><br><br>

        <label>Setor:</label><br>
        <input type="text" name="setor" value="{{ old('setor', $user->setor) }}"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
@endsection
