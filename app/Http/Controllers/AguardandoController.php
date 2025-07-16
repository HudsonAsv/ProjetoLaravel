<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Categoria;
use App\Models\Tema;

class AguardandoController extends Controller
{
    public function index()
    {
        $ocorrencias = Ocorrencia::where('status', 'aguardando')->with('categoria', 'tema')->latest()->get();
        return view('aguardando.index', compact('ocorrencias'));
    }

    public function show($id)
    {
        $ocorrencia = Ocorrencia::with('categoria', 'tema', 'atualizacaos')->findOrFail($id);
        return view('aguardando.detalhes', compact('ocorrencia'));
    }
}
