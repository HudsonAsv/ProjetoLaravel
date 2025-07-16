@extends('layouts.app')

@section('title', 'Ocorrências em Andamento')

@section('content')
<style>
    .card-andamento {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin: 30px auto;
        padding: 20px;
        max-width: 700px;
        transition: transform 0.3s;
    }

    .card-andamento:hover {
        transform: scale(1.01);
    }

    .card-andamento img {
        width: 100%;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    .card-andamento h3 {
        margin-bottom: 5px;
    }

    .card-tags {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .card-tags span {
        background-color: #e2e2e2;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
    }

    .card-andamento small {
        display: block;
        margin-top: 10px;
        color: #555;
        text-align: right;
    }
</style>

<h2 style="text-align: center;">Ocorrências em Andamento</h2>

@forelse($ocorrencias as $ocorrencia)
    <div class="card-andamento">
        <a href="{{ url('/andamento/' . $ocorrencia->id) }}" style="text-decoration: none; color: inherit;">
            <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência">
            <h3>{{ $ocorrencia->titulo }}</h3>

            <div class="card-tags">
                <span>{{ $ocorrencia->categoria->nome }}</span>
                <span>{{ $ocorrencia->tema->nome }}</span>
            </div>

            <p>{{ $ocorrencia->descricao }}</p>
            <small><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</small>
        </a>
    </div>
@empty
    <p style="text-align: center;">Nenhuma ocorrência em andamento encontrada.</p>
@endforelse
@endsection
