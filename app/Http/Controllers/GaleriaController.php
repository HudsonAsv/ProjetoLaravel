<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Categoria;
use App\Models\Tema;
use App\Services\ImageModerationService;


class GaleriaController extends Controller
{
    public function show($id)
{
    $ocorrencia = \App\Models\Ocorrencia::with('categoria', 'tema', 'comentarios')->findOrFail($id);
    return view('detalhes', compact('ocorrencia'));
}

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
    // Valida antes de qualquer coisa
    $request->validate([
        'titulo' => 'required|string|max:100',
        'descricao' => 'required|string',
        'localizacao' => 'required|string',
        'status' => 'required|string',
        'categoria_id' => 'required|exists:categorias,id',
        'tema_id' => 'required|exists:temas,id',
        'imagem' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Armazena imagem
    $imagemPath = $request->file('imagem')->store('ocorrencias', 'public');
    $imageUrl = asset('storage/' . $imagemPath);

    // Analisa com o serviço
    $moderator = new ImageModerationService();
    $resultado = $moderator->moderateFromUrl($imageUrl);

    if (!empty($resultado['nudity']) && $resultado['nudity']['raw'] > 0.7) {
        return back()->withErrors(['imagem' => 'A imagem foi considerada imprópria.']);
    }

    // Cria a ocorrência
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

}
