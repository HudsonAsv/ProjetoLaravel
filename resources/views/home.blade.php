
@extends('layouts.app')

@section('title', 'Painel de Ocorrências')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <h2>Resumo de Ocorrências</h2>

    <form method="GET" action="{{ url('/') }}" style="margin-bottom: 20px;">
        <label>Mês:</label>
        <select name="mes">
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

    <!-- Gráfico de status -->
    <canvas id="graficoStatus" height="200"></canvas>

    <!-- Gráfico de Categoria -->
<div style="display: flex; align-items: center; justify-content: center; gap: 40px; margin: 20px auto; max-width: 800px;">
    <div style="width: 100%;">
        <canvas id="graficoCategoria"></canvas>
    </div>

    <div>
        <label><strong>Categoria</strong></label><br>
        <select id="categoriaSelect" style="background-color: #ffdbdb; padding: 6px 12px; border-radius: 10px;">
            @foreach ($categoriaCount as $nome => $quantidade)
                <option value="{{ $nome }}">{{ $nome }}</option>
            @endforeach
        </select>
    </div>
</div>


    <!-- Gráfico de Tema -->
  <div style="display: flex; align-items: center; justify-content: center; gap: 40px; margin: 20px auto; max-width: 800px;">
    <div style="width: 100%;">
        <canvas id="graficoTema"></canvas>
        </div>
        <div>
            <label><strong>Ocorrências</strong></label><br>
            <select id="temaSelect" style="background-color: #ffdbdb; padding: 6px 12px; border-radius: 10px;">
                @foreach ($temaCount as $nome => $quantidade)
                    <option value="{{ $nome }}" {{ old('temaSelect') == $nome ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <script>
        // STATUS
        new Chart(document.getElementById('graficoStatus'), {
            type: 'bar',
            data: {
                labels: ['Concluído', 'Em andamento', 'Atrasado'],
                datasets: [{
                    label: 'Ocorrências',
                    data: [
                        {{ $statusCount['concluido'] ?? 0 }},
                        {{ $statusCount['em andamento'] ?? 0 }},
                        {{ $statusCount['atrasado'] ?? 0 }}
                    ],
                    backgroundColor: ['green', 'orange', 'red']
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 20,
                            maxTicksLimit: 6,
                            callback: v => Number.isInteger(v) ? v : ''
                        }
                    }
                }
            }
        });

        //JS Categoria
        const categoriaData = {!! json_encode($categoriaCount) !!};
        const categoriaSelect = document.getElementById('categoriaSelect');
        const categoriaInicial = categoriaSelect.value;

        const categoriaChart = new Chart(document.getElementById('graficoCategoria'), {
        type: 'bar',
        data: {
            labels: [categoriaInicial],
            datasets: [{
                label: 'Ocorrências por Categoria',
                data: [categoriaData[categoriaInicial]],
                backgroundColor: '#3454D1'
            }]
        },
        options: {
            indexAxis: 'y',
            maintainAspectRatio: true,
            scales: {
                x: {
                    beginAtZero: true,
                    suggestedMax: 10,
                    ticks: {
                        stepSize: 20,
                        callback: v => Number.isInteger(v) ? v : ''
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    categoriaSelect.addEventListener('change', function () {
        const categoria = this.value;
        categoriaChart.data.labels = [categoria];
        categoriaChart.data.datasets[0].data = [categoriaData[categoria]];
        categoriaChart.update();
    });

//JS TEMACHART
        const temaData = {!! json_encode($temaCount) !!};
        const temaSelect = document.getElementById('temaSelect');
        const temaInicial = temaSelect.value;

        const temaChart = new Chart(document.getElementById('graficoTema'), {
            type: 'bar',
            data: {
                labels: [temaInicial],
                datasets: [{
                    label: 'Ocorrências por Tema',
                    data: [temaData[temaInicial]],
                    backgroundColor: 'purple'
                }]
            },
            
         options: {
            indexAxis: 'y',
            maintainAspectRatio: true,
            scales: {
                x: {
                    beginAtZero: true,
                    suggestedMax: 10,
                    ticks: {
                        stepSize: 20,
                        callback: v => Number.isInteger(v) ? v : ''
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
            }
        });

        temaSelect.addEventListener('change', function () {
            const tema = this.value;
            temaChart.data.labels = [tema];
            temaChart.data.datasets[0].data = [temaData[tema]];
            temaChart.update();
        });
    </script>

    <!---RECENTES---->
    <h2 style="margin-top: 40px;">Ocorrências Recentes</h2>

<div class="galeria-grid">
    @foreach ($recentes as $ocorrencia)
        <a href="{{ url('/ocorrencia/' . $ocorrencia->id) }}" style="text-decoration: none; color: inherit;">
    <div class="galeria-card">
        <div class="imagem-thumb">
            <img src="{{ $ocorrencia->imagem }}" alt="Imagem da Ocorrência">
        </div>
        <h3>{{ $ocorrencia->titulo ?? 'Sem título' }}</h3>

        <div class="tags">
            <span class="tag">{{ $ocorrencia->tema->nome ?? 'Tema' }}</span>
            <span class="tag">{{ $ocorrencia->categoria->nome ?? 'Categoria' }}</span>
        </div>

        <p class="localizacao">📍 {{ $ocorrencia->localizacao }}</p>
        <p class="status">Status: {{ ucfirst($ocorrencia->status) }}</p>

        <div class="infos">
            <span class="data">📅 {{ \Carbon\Carbon::parse($ocorrencia->data_solicitacao)->format('d M Y') }}</span>
            <span class="like">👍 112</span>
            <span class="share">🔗 compartilhar</span>
        </div>
    </div>
</a>

    @endforeach
</div>

@endsection