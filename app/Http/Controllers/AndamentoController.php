<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;

class AndamentoController extends Controller
{
    public function index()
    {
        $ocorrencias = Ocorrencia::with(['categoria', 'tema'])
            ->where('status', 'em_andamento')
            ->latest()
            ->get();

        return view('andamento.index', compact('ocorrencias'));
    }

    public function show($id)
    {
        $ocorrencia = Ocorrencia::with(['categoria', 'tema', 'user', 'comentarios'])->findOrFail($id);
        return view('andamento.detalhes', compact('ocorrencia'));
    }
}
