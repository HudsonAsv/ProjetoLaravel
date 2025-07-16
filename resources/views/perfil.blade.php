@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
    <h2>Meu Perfil</h2>

    <div style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
        <p><strong>Nome:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Bio:</strong> {{ $user->bio ?? 'Nenhuma bio cadastrada' }}</p>
        <p><strong>Tipo de Conta:</strong> {{ ucfirst($user->role ?? 'padrão') }}</p>
        <p><strong>Setor:</strong> {{ $user->setor ?? 'Não especificado' }}</p>

        <a href="{{ route('perfil.edit') }}">
        <button>Editar Perfil</button></a>
    </div>
@endsection
