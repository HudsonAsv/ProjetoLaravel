@extends('layouts.app')

@section('title', $ocorrencia->titulo)

@section('content')

<style>
    .btn-tag {
        padding: 10px 20px;
        border-radius: 20px;
        background-color: #ececec;
        margin: 5px;
        border: none;
    }

    .btn-editar {
        position: absolute;
        top: 20px;
        right: 30px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }

    .status-form {
        margin-top: 20px;
    }

    .status-form select {
        padding: 5px 10px;
    }

    .status-form button {
        padding: 5px 12px;
        margin-left: 10px;
    }
</style>

<h2 style="text-align: center; margin-bottom: 10px;">{{ $ocorrencia->titulo }}</h2>

<div style="position: relative;">
    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" style="max-width: 100%; margin-bottom: 20px;">

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
    </select>

    <button type="submit">Atualizar Status</button>
</form>

</div>

<div style="display: flex; justify-content: center; flex-wrap: wrap;">
    <button class="btn-tag">{{ $ocorrencia->categoria->nome }}</button>
    <button class="btn-tag">{{ $ocorrencia->tema->nome }}</button>
</div>



<!-- Formulário de edição de status (se quiser deixar visível direto) -->
@if(Auth::check() && Auth::user()->role === 'admin')
    <form method="POST" action="{{ url('/admin/atualizar/' . $ocorrencia->id) }}" class="status-form">
        @csrf
        <label for="status"><strong>Mudar status:</strong></label>
        <select name="status" id="status">
            <option value="analise" {{ $ocorrencia->status == 'analise' ? 'selected' : '' }}>Em Análise</option>
            <option value="rejeitado" {{ $ocorrencia->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
            <option value="concluido" {{ $ocorrencia->status == 'concluido' ? 'selected' : '' }}>Concluído</option>
            <option value="em andamento" {{ $ocorrencia->status == 'em andamento' ? 'selected' : '' }}>Em Andamento</option>
            <option value="atrasado" {{ $ocorrencia->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
        </select>
        <button type="submit">Atualizar</button>
    </form>
@endif

<div style="margin-top: 40px;">
    <p><strong>Status:</strong> {{ $ocorrencia->status }}</p>
@if($ocorrencia->comentarios->isEmpty())
    <p>Sem comentários ainda.</p>
@else
    <h3>Comentários</h3>
    @foreach($ocorrencia->comentarios as $comentario)
        <div>
            <strong>{{ $comentario->user->name ?? 'Anônimo' }}</strong> disse:
            <p>{{ $comentario->conteudo }}</p>
        </div>
    @endforeach
@endif

</div>

@endsection
