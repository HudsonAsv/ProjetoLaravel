<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Categoria;
use App\Models\Tema;

class OcorrenciaController extends Controller
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

        // Gráfico 1 – Status
        $statusCount = $ocorrencias
            ->groupBy('status')
            ->map(fn($group) => $group->count());

        // Gráfico 2 – Categoria (usando nomes)
        $categoriaCount = $ocorrencias
            ->groupBy(fn($o) => $o->categoria->nome ?? 'Desconhecida')
            ->map->count();

        // Gráfico 3 – Tema (usando nomes)
        $temaCount = $ocorrencias
            ->groupBy(fn($o) => $o->tema->nome ?? 'Desconhecido')
            ->map->count();

        $categorias = Categoria::all();
        $temas = Tema::all();

$recentes = Ocorrencia::with(['categoria', 'tema'])
    ->orderBy('data_solicitacao', 'desc')
    ->take(6)
    ->get();


        return view('home', compact(
    'statusCount',
    'categoriaCount',
    'temaCount',
    'ocorrencias',
    'categorias',
    'temas',
    'recentes' // novo
    ));
    }
}
