<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Categoria;
use App\Models\Tema;

class AguardandoController extends Controller
{
    public function index(Request $request)
    {
        $query = Ocorrencia::where('status', 'recebido');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->filled('tema_id')) {
            $query->where('tema_id', $request->tema_id);
        }

        $ocorrencias = $query->with('categoria', 'tema')->latest()->get();
        $categorias = Categoria::all();
        $temas = Tema::all();

        return view('aguardando.index', [
            'ocorrencias' => $ocorrencias,
            'categorias' => $categorias,
            'temas' => $temas,
        ]);
    }

    public function show($id)
    {
        $ocorrencia = Ocorrencia::with('categoria', 'tema', 'atualizacaos')->findOrFail($id);
        return view('aguardando.detalhes', compact('ocorrencia'));
    }
}
