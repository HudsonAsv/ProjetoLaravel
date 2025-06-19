<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ocorrencia;

class OcorrenciaApiController extends Controller
{
    // Retorna todas as ocorrências
    public function index()
    {
        return response()->json(Ocorrencia::with(['categoria', 'tema'])->latest()->get());
    }

    // Retorna uma ocorrência específica por ID
    public function show($id)
    {
        $ocorrencia = Ocorrencia::with(['categoria', 'tema'])->findOrFail($id);
        return response()->json($ocorrencia);
    }

    // Armazena uma nova ocorrência
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'localizacao' => 'required|string',
            'status' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'imagem' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('imagens', 'public');
        }

        $data['data_solicitacao'] = now();

        $ocorrencia = Ocorrencia::create($data);

        return response()->json($ocorrencia, 201);
    }
}
