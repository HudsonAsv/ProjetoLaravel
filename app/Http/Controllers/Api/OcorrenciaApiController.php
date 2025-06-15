<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ocorrencia;

class OcorrenciaApiController extends Controller
{
    public function index()
    {
        return response()->json(Ocorrencia::all());
    }

    public function show($id)
    {
        return response()->json(Ocorrencia::findOrFail($id));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'titulo' => 'required',
        'descricao' => 'required',
        'localizacao' => 'required',
        'categoria_id' => 'required|integer',
        'tema_id' => 'required|integer',
        'status' => 'required',
        'imagem' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('imagem')) {
        $data['imagem'] = $request->file('imagem')->store('imagens', 'public');
    }

    $ocorrencia = Ocorrencia::create($data);

    return response()->json($ocorrencia, 201);
}

}
