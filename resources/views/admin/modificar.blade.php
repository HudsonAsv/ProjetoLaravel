@extends('layouts.app')

@section('title', 'Modificar Ocorrência')

@section('content')
    <h2>Modificar Ocorrência: {{ $ocorrencia->titulo }}</h2>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ url('/admin/atualizar/' . $ocorrencia->id) }}">
        @csrf

        <label>Status:</label>
        <select name="status">
            <option value="concluido">Concluído</option>
            <option value="em_andamento" selected>Em andamento</option>
            <option value="atrasado">Atrasado</option>
        </select><br><br>

        <label>Mensagem:</label><br>
        <textarea name="mensagem" rows="4" cols="50"></textarea><br><br>

        <label>Previsão de Conclusão:</label><br>
        <input type="date" name="previsao_conclusao"><br><br>

        <button type="submit">Atualizar</button>
    </form>

    <h3>Histórico de Atualizações</h3>
    @foreach($ocorrencia->atualizacaos as $atualizacao)
        <div class="card">
            <p>Status: {{ $atualizacao->status }}</p>
            <p>Mensagem: {{ $atualizacao->mensagem }}</p>
            <p>Previsão: {{ $atualizacao->previsao_conclusao }}</p>
        </div>
    @endforeach
@endsection
