@extends('layouts.app')

@section('title', $ocorrencia->titulo)

@section('content')
    <div style="max-width: 800px; margin: 20px auto; padding: 20px;">
        <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem" style="width: 100%; border-radius: 10px;">
        <p style="text-align: right; font-size: 14px; margin-top: 5px;">
            📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->translatedFormat('d/m/Y') }}
        </p>

        <h2>{{ $ocorrencia->titulo }}</h2>
        <p><strong>Localização:</strong> {{ $ocorrencia->rua ?? 'Não informada' }}</p>
        <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
        <div style="margin: 10px 0;">
            <span class="tag">{{ $ocorrencia->categoria->nome }}</span>
            <span class="tag">{{ $ocorrencia->tema->nome }}</span>
        </div>

        <h3>Atualizar status para o cidadão</h3>

        <div>
            <label>Histórico de Atualizações:</label>
            <textarea class="form-control" placeholder="Digite uma atualização..."></textarea>
        </div>

        <div>
            <label>Previsão de Conclusão:</label>
            <input type="date" class="form-control">
        </div>

        <div>
            <label>Status Atual:</label>
            <select class="form-control">
                <option>Recebido</option>
                <option>Em Análise</option>
                <option>Em Andamento</option>
                <option>Concluído</option>
                <option>Atrasado</option>
            </select>
        </div>

        <button class="btn btn-primary" style="margin-top: 10px;">Atualizar</button>
    </div>
@endsection
