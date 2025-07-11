@extends('layouts.app')

@section('title', 'Ocorrência ' . $ocorrencia->id)

@section('content')
    <h2>Ocorrência {{ $ocorrencia->id }}</h2>

    <div>
        <img src="{{  Storage::url($ocorrencia->imagem) }}" alt="Imagem da Ocorrência" style="max-width: 300px;">
    </div>

    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Localização:</strong> {{ $ocorrencia->rua }}, {{ $ocorrencia->numero ?? 'S/N' }} - {{ $ocorrencia->bairro }}</p>
    @if($ocorrencia->referencia)
        <p><strong>Referência:</strong> {{ $ocorrencia->referencia }}</p>
    @endif
    <p><strong>Status:</strong> {{ $ocorrencia->status }}</p>
    <p><strong>Categoria:</strong> {{ $ocorrencia->categoria->nome ?? 'N/A' }}</p>
    <p><strong>Tema:</strong> {{ $ocorrencia->tema->nome ?? 'N/A' }}</p>
    <p><strong>Nome do usuário:</strong> {{ $ocorrencia->user->name ?? 'N/A' }}</p>

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
               <strong>{{ $comentario->user->name ?? 'Anônimo' }}:</strong> {{ $comentario->conteudo }}<br>
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

    <form action="{{ route('comentario.store')}}" method="POST">
        @csrf
        <input type="hidden" name="ocorrencia_id" value="{{ $ocorrencia->id }}">
        <label for="conteudo">Seu Comentário:</label><br>
        <textarea id="conteudo" name="conteudo" rows="4" required>{{ old('conteudo') }}</textarea><br><br>

        <button type="submit">Enviar Comentário</button>
    </form>
@endsection
