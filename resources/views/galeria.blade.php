@extends('layouts.app')

@section('title', 'Galeria de Ocorrências')

@section('content')
    <h2>Galeria de Ocorrências</h2>

    <!-- Formulário de Filtro -->
    <form method="GET" action="{{ url('/galeria') }}" style="margin-bottom: 20px;">
        <label>Mês:</label>
        <select name="mes">
            <option value="">Todos</option>
            @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ request('mes') == $m ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endforeach
        </select>


        <label>Categoria:</label>
        <select name="categoria_id">
            <option value="">Todas</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>

        <label>Tema:</label>
        <select name="tema_id">
            <option value="">Todos</option>
            @foreach ($temas as $tema)
                <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>
                    {{ $tema->nome }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrar</button>
    </form>

    <!-- Grid de Ocorrências -->
    <div class="galeria-grid">
        @forelse ($ocorrencias as $ocorrencia)
            <div class="galeria-card">
                <div class="imagem-thumb">
                    <img src="{{ Storage::url($ocorrencia->imagem) }}" alt="Imagem da Ocorrência">

                </div>
                <h3>{{ $ocorrencia->titulo ?? 'Assunto' }}</h3>

                <div class="tags">
                    <span class="tag">{{ $ocorrencia->tema->nome ?? 'Tema' }}</span>
                    <span class="tag">{{ $ocorrencia->categoria->nome ?? 'Categoria' }}</span>
                </div>

                <p class="localizacao">Localização: {{ $ocorrencia->rua }}, {{ $ocorrencia->bairro }}</p>
                <p class="status">Status: {{ ucfirst($ocorrencia->status) }}</p>

                <div class="infos">
                    <span class="data">
                        📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d M Y') }}
                    </span>
                    <span class="like">👍 112</span>
                    <span class="share">🔗 compartilhar</span>
                </div>
            </div>
        @empty
            <p>Nenhuma ocorrência encontrada com os filtros selecionados.</p>
        @endforelse
    </div>
@endsection