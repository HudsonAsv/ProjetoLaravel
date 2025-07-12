<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Categoria;
use App\Models\Tema;

class RejeitadosController extends Controller
{
    public function index(Request $request)
    {
        $query = Ocorrencia::where('status', 'rejeitado');

        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('tema_id')) {
            $query->where('tema_id', $request->tema_id);
        }

        if ($request->filled('motivo')) {
            $query->where('motivo_rejeicao', 'like', '%' . $request->motivo . '%');
        }

        $ocorrencias = $query->with('categoria', 'tema')->latest()->get();
        $categorias = Categoria::all();
        $temas = Tema::all();

        return view('rejeitados', [
            'rejeitadas' => $ocorrencias,
            'categorias' => $categorias,
            'temas' => $temas,
        ]);
    }
}
