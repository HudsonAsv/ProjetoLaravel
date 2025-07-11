@extends('layouts.app')

@section('title', 'Projetos Rejeitados')

@section('content')
    <h2 style="text-align:center;">Projetos Rejeitados</h2>

    <!-- Filtros -->
    <form method="GET" action="{{ url('/rejeitados') }}" style="margin-bottom: 20px; text-align: center;">
        <label>Categoria:</label>
        <select name="categoria_id">
            <option value="">Todas</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>

        <label>Tema:</label>
        <select name="tema_id">
            <option value="">Todos</option>
            @foreach($temas as $tema)
                <option value="{{ $tema->id }}" {{ request('tema_id') == $tema->id ? 'selected' : '' }}>
                    {{ $tema->nome }}
                </option>
            @endforeach
        </select>

        <label>Motivo da Rejeição:</label>
        <input type="text" name="motivo" value="{{ request('motivo') }}" placeholder="Ex: Linguagem ofensiva">

        <button type="submit">Filtrar</button>
    </form>

    <!-- Lista de Ocorrências Rejeitadas -->
    <div class="galeria-grid">
        @forelse($rejeitadas as $ocorrencia)
            <div class="galeria-card">
                <div class="imagem-thumb">
                    <img src="{{ asset('storage/' . $ocorrencia->imagem) }}" alt="Imagem da Ocorrência" style="filter: blur(4px);">
                </div>

                <h3>{{ $ocorrencia->titulo }}</h3>

                <div class="tags">
                    <span class="tag">{{ $ocorrencia->categoria->nome ?? 'Categoria' }}</span>
                    <span class="tag">{{ $ocorrencia->tema->nome ?? 'Tema' }}</span>
                </div>

                <p class="status">Rejeitado em {{ \Carbon\Carbon::parse($ocorrencia->updated_at)->format('d/m/Y') }}</p>
                <p class="localizacao">📍 {{ $ocorrencia->localizacao }}</p>

                <div class="infos">
                    <p><strong>Motivo:</strong> {{ $ocorrencia->motivo_rejeicao ?? 'Motivo não especificado' }}</p>
                    <span class="data">📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d M Y') }}</span>
                    <span class="views">👁️ {{ $ocorrencia->visualizacoes ?? 0 }}</span>
                </div>
            </div>
        @empty
            <p style="text-align:center;">Nenhum projeto rejeitado encontrado.</p>
        @endforelse
    </div>
@endsection
