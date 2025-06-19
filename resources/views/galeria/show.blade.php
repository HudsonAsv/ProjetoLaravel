@extends('layouts.app')

@section('title', 'Detalhes da Ocorrência')

@section('content')
    <h2>{{ $ocorrencia->titulo }}</h2>
@php use Illuminate\Support\Str; @endphp

@if(Str::startsWith($ocorrencia->imagem, ['http://', 'https://']))
    <img src="{{ $ocorrencia->imagem }}" alt="Imagems" style="max-width: 600px; width: 100%; height: auto;">
@else
    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="[ Imagem ]" style="max-width: 600px; width: 100%; height: auto;">
@endif

    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Localização:</strong> {{ $ocorrencia->localizacao }}</p>
    <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</p>
    <p><strong>Categoria:</strong> {{ $ocorrencia->categoria->nome ?? 'N/A' }}</p>
    <p><strong>Tema:</strong> {{ $ocorrencia->tema->nome ?? 'N/A' }}</p>

    <!-- Botão para editar status -->
    <form method="POST" action="{{ url('/ocorrencia/atualizar/' . $ocorrencia->id) }}">
        @csrf
        @method('PUT')

        <label for="status"><strong>Atualizar Status:</strong></label>
        <select name="status" id="status">
            <option value="em andamento" {{ $ocorrencia->status == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
            <option value="concluido" {{ $ocorrencia->status == 'concluido' ? 'selected' : '' }}>Concluído</option>
            <option value="atrasado" {{ $ocorrencia->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>
        <button type="submit">Salvar</button>
    </form>

    <hr>

    <h3>Comentários</h3>

    @foreach ($ocorrencia->comentarios as $comentario)
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
            <strong>{{ $comentario->autor }}</strong> - {{ $comentario->created_at->format('d/m/Y H:i') }}<br>
            {{ $comentario->mensagem }}
            <form method="POST" action="{{ url('/comentario/' . $comentario->id) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Excluir este comentário?')">🗑</button>
            </form>
        </div>
    @endforeach

    <hr>

    <h4>Adicionar Comentário</h4>
    <form method="POST" action="{{ url('/comentario/' . $ocorrencia->id) }}">
        @csrf
        <label for="autor">Seu nome (opcional):</label>
        <input type="text" name="autor" id="autor"><br>

        <label for="mensagem">Comentário:</label><br>
        <textarea name="mensagem" id="mensagem" rows="4" required></textarea><br>

        <button type="submit">Enviar</button>
    </form>

    <br>
    <a href="{{ url('/') }}">← Voltar ao painel</a>
@endsection
