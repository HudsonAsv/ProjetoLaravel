@extends('layouts.app')

@section('title', $ocorrencia->titulo)

@section('content')
    <h2>{{ $ocorrencia->titulo }}</h2>
    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" width="400" alt="Imagem da Ocorrência">

    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Localização:</strong> {{ $ocorrencia->localizacao }}</p>
    <p><strong>Status:</strong> {{ $ocorrencia->status }}</p>
    <p><strong>Categoria:</strong> {{ $ocorrencia->categoria->nome ?? '---' }}</p>
    <p><strong>Tema:</strong> {{ $ocorrencia->tema->nome ?? '---' }}</p>

    <h3>Histórico de Atualizações</h3>
    @foreach($ocorrencia->atualizacaos as $atualizacao)
        <div class="card">
            <p>{{ $atualizacao->created_at->format('d/m/Y H:i') }} - {{ $atualizacao->status }}</p>
            <p>{{ $atualizacao->mensagem }}</p>
            <p>Previsão de conclusão: {{ $atualizacao->previsao_conclusao ?? '---' }}</p>
        </div>
    @endforeach
@endsection
