<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;

class SuspensosController extends Controller
{
    public function index()
    {
        $ocorrencias = Ocorrencia::with('categoria', 'tema')
            ->where('status', 'suspenso')
            ->latest()
            ->get();

        return view('suspensos.index', compact('ocorrencias'));
    }
}
