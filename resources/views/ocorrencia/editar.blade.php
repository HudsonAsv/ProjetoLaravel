@extends('layouts.app')

@section('content')
<h2>Editar Status da Ocorrência</h2>

<form action="{{ url('/ocorrencia/atualizar/' . $ocorrencia->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Status:</label>
    <select name="status" required>
        <option value="concluido" {{ $ocorrencia->status == 'concluido' ? 'selected' : '' }}>Concluído</option>
        <option value="em andamento" {{ $ocorrencia->status == 'em andamento' ? 'selected' : '' }}>Em andamento</option>
        <option value="atrasado" {{ $ocorrencia->status == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
    </select>

    <button type="submit">Atualizar</button>
</form>
@endsection