<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Categoria;
use App\Models\Tema;
use App\Models\Comentario;


class GaleriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Ocorrencia::query();

        if ($request->filled('mes')) {
            $query->whereMonth('data_solicitacao', $request->mes);
        }

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('tema_id')) {
            $query->where('tema_id', $request->tema_id);
        }

        $ocorrencias = $query->with('categoria', 'tema')->get();
        $categorias = Categoria::all();
        $temas = Tema::all();

        return view('galeria', compact('ocorrencias', 'categorias', 'temas'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $temas = Tema::all();

        return view('ocorrencia.criar', compact('categorias', 'temas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descricao' => 'required|string',
            'localizacao' => 'required|string',
            'status' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'imagem' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagemPath = $request->file('imagem')->store('ocorrencias', 'public');

        Ocorrencia::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'localizacao' => $request->localizacao,
            'status' => $request->status,
            'categoria_id' => $request->categoria_id,
            'tema_id' => $request->tema_id,
            'imagem' => $imagemPath,
            'data_solicitacao' => now(),
        ]);

        return redirect('/galeria')->with('success', 'Ocorrência cadastrada com sucesso!');
    }

    public function show($id)
{
    $ocorrencia = Ocorrencia::with('comentarios')->findOrFail($id);
    return view('galeria.show', compact('ocorrencia'));
}


    public function edit($id)
    {
        $ocorrencia = Ocorrencia::findOrFail($id);
        return view('ocorrencias.editar', compact('ocorrencia'));
    }

    public function update(Request $request, $id)
{
    $ocorrencia = Ocorrencia::findOrFail($id);
    $ocorrencia->status = $request->status;
    $ocorrencia->save();

    return redirect('/')->with('success', 'Status atualizado com sucesso!');
}


public function adicionarComentario(Request $request, $id)
{
    $request->validate([
        'autor' => 'nullable|string|max:50',
        'mensagem' => 'required|string|max:500',
    ]);

    Comentario::create([
        'ocorrencia_id' => $id,
        'autor' => $request->autor ?? 'Anônimo',
        'mensagem' => $request->mensagem
    ]);

    return back()->with('success', 'Comentário adicionado.');
}


public function deletarComentario($id)
{
    Comentario::findOrFail($id)->delete();
    return back()->with('success', 'Comentário excluído.');
}


}
