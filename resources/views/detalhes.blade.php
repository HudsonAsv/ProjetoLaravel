@extends('layouts.app')

@section('title', 'Ocorrência ' . $ocorrencia->id)

@section('content')
    <h2>Ocorrência {{ $ocorrencia->id }}</h2>

    <div>
        <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" style="max-width: 300px;">
    </div>

    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Localização:</strong> {{ $ocorrencia->localizacao }}</p>
    <p><strong>Status:</strong> {{ $ocorrencia->status }}</p>
    <p><strong>Categoria:</strong> {{ $ocorrencia->categoria->nome ?? 'N/A' }}</p>
    <p><strong>Tema:</strong> {{ $ocorrencia->tema->nome ?? 'N/A' }}</p>

    <h3>Histórico de Atualizações</h3>
    <ul>
        @foreach($ocorrencia->atualizacaos as $atualizacao)
            <li>{{ $atualizacao->mensagem }} - <em>{{ $atualizacao->created_at->format('d/m/Y H:i') }}</em></li>
        @endforeach
    </ul>

    <h3>Comentários</h3>
    <ul>
        @forelse ($ocorrencia->comentarios as $comentario)
            <li>
                <strong>{{ $comentario->autor }}:</strong> {{ $comentario->mensagem }}<br>
                <small>{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
            </li>
        @empty
            <li>Nenhum comentário ainda.</li>
        @endforelse
    </ul>

    <h4>Adicionar Comentário</h4>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('comentario.store') }}" method="POST">
        @csrf
        <input type="hidden" name="ocorrencia_id" value="{{ $ocorrencia->id }}">

        <label for="autor">Seu nome:</label><br>
        <input type="text" id="autor" name="autor" value="{{ old('autor') }}" required><br><br>

        <label for="mensagem">Comentário:</label><br>
        <textarea id="mensagem" name="mensagem" rows="4" required>{{ old('mensagem') }}</textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
@endsection
