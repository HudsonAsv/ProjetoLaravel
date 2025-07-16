@extends('layouts.app')

@section('title', 'Ocorrências Rejeitadas')

@section('content')

<h2>Ocorrências Rejeitadas</h2>

<form method="GET" action="{{ url('/rejeitados') }}" style="display: flex; gap: 10px; margin-bottom: 20px;">
    <div>
        <label>Temas</label>
        <select name="tema_id" class="filtro-select">
            <option value="">Todos</option>
            @foreach ($temas as $tema)
                <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>{{ $tema->nome }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Categoria</label>
        <select name="categoria_id" class="filtro-select">
            <option value="">Todas</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Rejeição por:</label>
        <select name="motivo" class="filtro-select">
            <option value="">Descrição</option>
            <option value="imagem" {{ request('motivo') == 'imagem' ? 'selected' : '' }}>Imagem</option>
            <option value="conteúdo" {{ request('motivo') == 'conteúdo' ? 'selected' : '' }}>Conteúdo</option>
        </select>
    </div>

    <button type="submit" class="filtro-btn">Filtrar</button>
</form>

<div class="galeria-grid">
    @forelse ($rejeitadas as $ocorrencia)
        <div class="galeria-card">
            <a href="{{ url('/ocorrencia/' . $ocorrencia->id) }}" style="text-decoration: none; color: inherit;">
            <div class="imagem-thumb">
                <img src="{{ Storage::url($ocorrencia->imagem) }}" alt="Conteúdo sensível" style="filter: blur(5px);" />
            </div>

            <h3>{{ $ocorrencia->titulo }}</h3>

            <div class="tags">
                <span class="tag">{{ $ocorrencia->categoria->nome ?? 'Categoria' }}</span>
                <span class="tag">{{ $ocorrencia->tema->nome ?? 'Tema' }}</span>
            </div>

            <div class="infos">
                <span class="data">📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('M, d Y') }}</span>
                <span class="like">👁 {{ $ocorrencia->visualizacoes ?? 0 }}</span>
            </div>
        </div>
    @empty
        <p>Nenhuma ocorrência rejeitada encontrada.</p>
    @endforelse
</div>

@endsection
