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
        font-size: 14px;
    }
    .status-form {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    .status-form select,
    .status-form button {
        padding: 8px 12px;
        margin: 5px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .imagem-centralizada {
        display: block;
        margin: 20px auto;
        max-width: 100%;
        max-height: 400px;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .info-box {
        margin-top: 20px;
        border-top: 1px solid #eee;
        padding-top: 20px;
    }
    .rodape-imagem {
        text-align: right;
        font-size: 14px;
        color: #777;
        margin-top: -10px;
        margin-bottom: 10px;
    }
    .botoes-interativos {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 25px;
    }
    .comentario-box {
        border: 1px solid #e9e9e9;
        background-color: #fafafa;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
    }
</style>

<h2 style="text-align: center; margin-bottom: 10px;">{{ $ocorrencia->titulo }}</h2>

<div style="display: flex; justify-content: center; flex-wrap: wrap;">
    <button class="btn-tag">{{ $ocorrencia->categoria->nome }}</button>
    <button class="btn-tag">{{ $ocorrencia->tema->nome }}</button>
</div>

<div>
    @if($ocorrencia->imagem)
        <img src="{{ Storage::url($ocorrencia->imagem) }}" alt="Imagem da Ocorrência" class="imagem-centralizada">
    @endif
    <div class="rodape-imagem">
        <span>📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d/m/Y') }}</span>
    </div>
</div>

<div class="info-box">
    <p><strong>Status:</strong> {{ ucfirst($ocorrencia->status) }}</p>
    <p><strong>Descrição:</strong> {{ $ocorrencia->descricao }}</p>
    <p><strong>Localização:</strong> Rua {{ $ocorrencia->rua }}, Nº {{ $ocorrencia->numero ?? '-' }}, Bairro {{ $ocorrencia->bairro }}</p>
    <p><strong>Ponto de Referência:</strong> {{ $ocorrencia->referencia ?? 'Não informado' }}</p>
    <p><strong>Publicado por:</strong> {{ $ocorrencia->user->name ?? 'Usuário desconhecido' }}</p>
</div>

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

<hr style="margin-top: 30px;">
<div style="margin-top: 20px;">
    <h3>Comentários</h3>
    @forelse($ocorrencia->comentarios as $comentario)
        <div class="comentario-box">
            <strong>{{ $comentario->user->name ?? 'Anônimo' }}:</strong>
            <p style="margin-top: 5px;">{{ $comentario->conteudo }}</p>
            <small>{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
        </div>
    @empty
        <p>Nenhum comentário ainda.</p>
    @endforelse
</div>

@if(auth()->check())
    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            <strong style="display: block; margin-bottom: 5px;">Ocorreu um erro:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($ocorrencia) && $ocorrencia->id)
        <form action="{{ route('comentario.store', $ocorrencia->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="ocorrencia_id" value="{{ $ocorrencia->id }}">

            <div>
                <label for="conteudo"><strong>Adicionar Comentário:</strong></label><br>
                <textarea id="conteudo" name="conteudo" rows="4" required style="width: 100%; margin-top: 5px;">{{ old('conteudo') }}</textarea>
            </div>
            <br>
            <button type="submit">Enviar Comentário</button>
        </form>
    @endif
@endif

<div class="botoes-interativos">
    <button style="background-color: #ddd; padding: 8px 12px;">👍 Curtir</button>
    <button style="background-color: #ddd; padding: 8px 12px;">🔗 Compartilhar</button>
</div>
@endsection
