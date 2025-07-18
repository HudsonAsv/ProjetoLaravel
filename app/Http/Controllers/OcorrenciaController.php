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
        $publicStatuses = ['recebido', 'concluido', 'em_andamento', 'atrasado'];

        $query = Ocorrencia::whereIn('status', $publicStatuses);

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

        $statusCount = $ocorrencias
            ->groupBy('status')
            ->map(fn($group) => $group->count());

        $categoriaCount = $ocorrencias
            ->groupBy(fn($o) => $o->categoria->nome ?? 'Desconhecida')
            ->map->count();

        $temaCount = $ocorrencias
            ->groupBy(fn($o) => $o->tema->nome ?? 'Desconhecido')
            ->map->count();

        $categorias = Categoria::all();
        $temas = Tema::all();
        $recentes = Ocorrencia::with(['categoria', 'tema'])
        ->whereIn('status', $publicStatuses)
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
    'recentes'
    ));
    }
}
