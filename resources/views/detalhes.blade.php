@extends('layouts.app')

@section('title', $ocorrencia->titulo)

@section('content')
<style>
    .btn-tag {
        padding: 8px 16px;
        border-radius: 20px;
        background-color: #ececec;
        margin: 4px;
        border: none;
    }

    .status-form {
        margin-top: 20px;
    }

    .status-form select,
    .status-form button {
        padding: 6px 10px;
        margin: 5px 0;
    }

    .imagem-centralizada {
        display: block;
        margin: 0 auto;
        max-width: 100%;
    }

    .info-box {
        margin-top: 20px;
        border-top: 1px solid #ccc;
        padding-top: 20px;
    }

    .rodape-imagem {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #777;
        margin: 10px 0;
    }

    .botoes-interativos {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .comentario-box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<h2 style="text-align: center; margin-bottom: 10px;">{{ $ocorrencia->titulo }}</h2>

<!-- Imagem da ocorrência -->
<div>
    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" class="imagem-centralizada">

    <!-- Data no canto inferior direito da imagem -->
    <div class="rodape-imagem">
        <div></div>
        <div>📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</div>
    </div>
</div>

<!-- Tags de Categoria e Tema -->
<div style="display: flex; justify-content: center; flex-wrap: wrap;">
    <button class="btn-tag">{{ $ocorrencia->categoria->nome }}</button>
    <button class="btn-tag">{{ $ocorrencia->tema->nome }}</button>
</div>



<!-- Informações da ocorrência -->
<div class="info-box">
    <p><strong>Status:</strong> {{ ucfirst($ocorrencia->status) }}</p>
    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Localização:</strong> Rua {{ $ocorrencia->rua }}, Nº {{ $ocorrencia->numero ?? '-' }}, Bairro {{ $ocorrencia->bairro }}</p>
    <p><strong>Ponto de Referência:</strong> {{ $ocorrencia->referencia ?? 'Não informado' }}</p>
    <p><strong>Publicado por:</strong> {{ $ocorrencia->user->name ?? 'Usuário desconhecido' }}</p>
</div>
<!-- Botão flutuante para editar -->
    <form method="POST" action="{{ url('/admin/atualizar/' . $ocorrencia->id) }}">
    @csrf
    {{-- se o método da rota for PUT/PATCH --}}
    @method('POST')

    <select name="status" required>
        <option value="">Selecione o status</option>
        <option value="recebido">Recebido</option>
        <option value="em_analise">Em Análise</option>
        <option value="em_andamento">Em Andamento</option>
        <option value="concluido">Concluído</option>
        <option value="atrasado">Atrasado</option>
        <option value="rejeitado">Rejeitado</option>
    </select>

    <button type="submit">Atualizar Status</button>
</form>
<!-- Formulário de alteração de status -->
@if(Auth::check() && Auth::user()->role === 'admin')
    <form method="POST" action="{{ url('/admin/atualizar/' . $ocorrencia->id) }}" class="status-form">
        @csrf
        <label for="status"><strong>Atualizar status:</strong></label>
        <select name="status" id="status" required>
            <option value="">Selecione</option>
            <option value="recebido" {{ $ocorrencia->status == 'recebido' ? 'selected' : '' }}>Recebido</option>
            <option value="em_analise" {{ $ocorrencia->status == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
            <option value="em_andamento" {{ $ocorrencia->status == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
            <option value="concluido" {{ $ocorrencia->status == 'concluido' ? 'selected' : '' }}>Concluído</option>
            <option value="atrasado" {{ $ocorrencia->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
            <option value="rejeitado" {{ $ocorrencia->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
        </select>
        <button type="submit">Salvar</button>
    </form>
@endif

<!-- Comentários -->
<hr>
@if(auth()->check())
    <form action="{{ route('comentario.store', ['ocorrencia' => $ocorrencia->id]) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <label for="conteudo"><strong>Comente sobre essa ocorrência:</strong></label>
        <textarea name="conteudo" id="conteudo" rows="3" required style="width: 100%;"></textarea>
        <button type="submit">Enviar Comentário</button>
    </form>
@endif

@if($ocorrencia->comentarios->isEmpty())
    <p style="margin-top: 10px;">Nenhum comentário ainda.</p>
@else
    <div style="margin-top: 20px;">
        <h3>Comentários</h3>
        @foreach($ocorrencia->comentarios as $comentario)
            <div class="comentario-box">
                <strong>{{ $comentario->user->name ?? 'Anônimo' }}:</strong>
                <p>{{ $comentario->conteudo }}</p>
                <small>{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @endforeach
    </div>
@endif
<!-- Interações -->
<div class="botoes-interativos">
    <button style="background-color: #ddd; padding: 8px 12px;">👍 Curtir</button>
    <button style="background-color: #ddd; padding: 8px 12px;">🔗 Compartilhar</button>
</div>
@endsection
