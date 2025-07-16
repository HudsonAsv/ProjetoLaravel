@extends('layouts.app')

@section('title', 'Aguardando Aprovação')

@section('content')
    <div class="galeria-grid">
        @forelse($ocorrencias as $ocorrencia)
            <a href="{{ url('/aguardando/' . $ocorrencia->id) }}" class="galeria-card" style="text-decoration: none;">
                <div class="imagem-thumb">
                    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" style="max-width: 100%;">
                </div>
                <div class="info">
                    <h3>{{ $ocorrencia->titulo }}</h3>
                    <div style="display: flex; gap: 10px;">
                        <span class="tag">{{ $ocorrencia->categoria->nome }}</span>
                        <span class="tag">{{ $ocorrencia->tema->nome }}</span>
                    </div>
                    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->translatedFormat('d/m/Y') }}</p>
                </div>
            </a>
        @empty
            <p style="text-align: center;">Nenhuma ocorrência aguardando aprovação.</p>
        @endforelse
    </div>
@endsection
