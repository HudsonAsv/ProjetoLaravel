@extends('layouts.app')

@section('title', 'Em Andamento')

@section('content')
<div class="galeria-grid">
    @foreach($ocorrencias as $ocorrencia)
        <div class="galeria-card">
            <div class="imagem-thumb">
                <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem" style="width:100%;">
            </div>
            <div class="info">
                <h3>{{ $ocorrencia->titulo }}</h3>
                <p><strong>Categoria:</strong> {{ $ocorrencia->categoria->nome }}</p>
                <p><strong>Tema:</strong> {{ $ocorrencia->tema->nome }}</p>
                <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
