<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ocorrencia_id' => 'required|exists:ocorrencias,id',
            'autor' => 'required|string|max:100',
            'mensagem' => 'required|string|max:1000',
        ]);

        Comentario::create([
            'ocorrencia_id' => $request->ocorrencia_id,
            'autor' => $request->autor,
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }
}
