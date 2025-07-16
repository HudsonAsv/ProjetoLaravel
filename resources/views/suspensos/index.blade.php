@extends('layouts.app')
@section('title', 'Ocorrências Suspensas')

@section('content')
    <h2 style="text-align: center; margin: 20px 0;">Ocorrências Suspensas</h2>

    <div style="display: flex; flex-direction: column; gap: 20px; padding: 20px;">
        @forelse($ocorrencias as $ocorrencia)
            <a href="{{ url('/ocorrencia/' . $ocorrencia->id) }}" style="text-decoration: none; color: inherit;">
                <div style="background: #f9f9f9; border-radius: 8px; padding: 16px; box-shadow: 0 0 4px rgba(0,0,0,0.1);">
                    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 6px;">
                    <h3>{{ $ocorrencia->titulo }}</h3>
                    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
                    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</p>
                </div>
            </a>
        @empty
            <p style="text-align: center;">Nenhuma ocorrência suspensa encontrada.</p>
        @endforelse
    </div>
@endsection
