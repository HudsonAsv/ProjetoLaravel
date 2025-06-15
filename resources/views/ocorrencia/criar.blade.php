@extends('layouts.app')

@section('title', 'Nova Ocorrência')

@section('content')
    <h2>Criar Ocorrência</h2>

    <form method="POST" action="{{ url('/ocorrencia/salvar') }}" enctype="multipart/form-data">
        @csrf

        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" rows="4" required></textarea><br><br>

        <label>Localização:</label><br>
        <input type="text" name="localizacao" required><br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="em andamento">Em andamento</option>
            <option value="concluido">Concluído</option>
            <option value="atrasado">Atrasado</option>
        </select><br><br>

        <label>Categoria:</label><br>
        <select name="categoria_id" required>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
            @endforeach
        </select><br><br>

        <label>Tema:</label><br>
        <select name="tema_id" required>
            @foreach ($temas as $tema)
                <option value="{{ $tema->id }}">{{ $tema->nome }}</option>
            @endforeach
        </select><br><br>

        <label>Imagem:</label><br>
        <input type="file" name="imagem" accept="image/*" required><br><br>

        <button type="submit">Salvar Ocorrência</button>
    </form>
@endsection
