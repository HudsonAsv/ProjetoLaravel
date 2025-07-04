<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Ocorrencia;

class ComentarioController extends Controller
{
    public function store(Request $request, $ocorrenciaId)
    {
        $request->validate([
            'autor' => 'nullable|string|max:100',
            'mensagem' => 'required|string|max:1000',
        ]);

        Comentario::create([
            'ocorrencia_id' => $ocorrenciaId,
            'autor' => $request->autor ?? 'Anônimo',
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->route('ocorrencia.show', $ocorrenciaId)
                         ->with('success', 'Comentário adicionado com sucesso.');
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);
        $ocorrenciaId = $comentario->ocorrencia_id;
        $comentario->delete();

        return redirect()->route('ocorrencia.show', $ocorrenciaId)
                         ->with('success', 'Comentário removido com sucesso.');
    }
}
