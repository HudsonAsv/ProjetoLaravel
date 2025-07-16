<?php

namespace App\Http\Controllers;
use App\Models\Ocorrencia;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Tema;

class AnaliseController extends Controller
{
    public function index(Request $request)
    {
        $query = Ocorrencia::where('status', 'em_analise');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        if ($request->filled('tema_id')) {
            $query->where('tema_id', $request->tema_id);
        }

        $ocorrencias = $query->with('categoria', 'tema')->latest()->get();
        $categorias = Categoria::all();
        $temas = Tema::all();

        return view('analise', [
            'ocorrencias' => $ocorrencias,
            'categorias' => $categorias,
            'temas' => $temas,
        ]);
    }
}
