@extends('layouts.app')

@section('title', 'Detalhes da Ocorrência')

@section('content')
<div class="detalhes-container">
    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" class="imagem-centralizada">
    <p class="data-imagem">
        <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}
    </p>

    <h2>{{ $ocorrencia->titulo }} - {{ $ocorrencia->tema->nome }}</h2>

    <div class="tags">
        <button>{{ $ocorrencia->categoria->nome }}</button>
        <button>{{ $ocorrencia->tema->nome }}</button>
    </div>

    <p><strong>Localização:</strong> {{ $ocorrencia->rua ?? 'Indefinida' }}</p>
    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Postado por:</strong> {{ $ocorrencia->user->name ?? 'Anônimo' }}</p>

    <p><strong>Status:</strong> {{ ucfirst($ocorrencia->status) }}</p>

    {{-- Comentários --}}
    <h3>Comentários</h3>
    @foreach($ocorrencia->comentarios as $comentario)
        <div class="comentario">
            <strong>{{ $comentario->user->name ?? 'Anônimo' }}:</strong>
            <p>{{ $comentario->conteudo }}</p>
            <small>{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
        </div>
    @endforeach
@endsection
