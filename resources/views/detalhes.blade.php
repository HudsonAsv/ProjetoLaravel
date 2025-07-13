@extends('layouts.app')

@section('title', $ocorrencia->titulo)

@section('content')

<style>
    .btn-tag {
        padding: 10px 20px;
        border-radius: 20px;
        background-color: #ececec;
        margin: 5px;
        border: none;
    }

    .btn-editar {
        position: absolute;
        top: 20px;
        right: 30px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    .status-form {
        margin-top: 20px;
    }

    .status-form select {
        padding: 5px 10px;
    }

    .status-form button {
        padding: 5px 12px;
        margin-left: 10px;
    }
</style>

<h2 style="text-align: center; margin-bottom: 10px;">{{ $ocorrencia->titulo }}</h2>

<div style="position: relative;">
    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" style="max-width: 100%; margin-bottom: 20px;">

    <!-- Botão flutuante para editar -->
    <form method="POST" action="{{ url('/admin/atualizar/' . $ocorrencia->id) }}" class="btn-editar">
        @csrf
        <input type="hidden" name="status" value="editar">
        <button title="Editar Status">🖉</button>
    </form>
</div>

<div style="display: flex; justify-content: center; flex-wrap: wrap;">
    <button class="btn-tag">{{ $ocorrencia->categoria->nome }}</button>
    <button class="btn-tag">{{ $ocorrencia->tema->nome }}</button>
</div>

<div style="margin-top: 20px;">
    <p>📍 <strong>Localização:</strong> {{ $ocorrencia->localizacao }}</p>
    <p>📝 <strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p>📅 <strong>Data da solicitação:</strong> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</p>
</div>

<!-- Formulário de edição de status (se quiser deixar visível direto) -->
@if(Auth::check() && Auth::user()->role === 'admin')
    <form method="POST" action="{{ url('/admin/atualizar/' . $ocorrencia->id) }}" class="status-form">
        @csrf
        <label for="status"><strong>Mudar status:</strong></label>
        <select name="status" id="status">
            <option value="analise" {{ $ocorrencia->status == 'analise' ? 'selected' : '' }}>Em Análise</option>
            <option value="rejeitado" {{ $ocorrencia->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
            <option value="concluido" {{ $ocorrencia->status == 'concluido' ? 'selected' : '' }}>Concluído</option>
            <option value="em andamento" {{ $ocorrencia->status == 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
            <option value="atrasado" {{ $ocorrencia->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>
        <button type="submit">Atualizar</button>
    </form>
@endif

<div style="margin-top: 40px;">
    <span>👍 {{ $ocorrencia->likes ?? 94 }}</span>
    <span style="margin-left: 30px;">🔗 compartilhar</span>
</div>

@endsection
