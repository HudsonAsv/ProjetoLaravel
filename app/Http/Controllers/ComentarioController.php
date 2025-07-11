<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Ocorrencia; // Importe o modelo Ocorrencia
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ComentarioController extends Controller
{
    public function index(Ocorrencia $ocorrencia)
    {
        $comentarios = $ocorrencia->comentarios()->with('user:id,name')->latest()->get();
        return response()->json($comentarios);
    }

    public function store(Request $request, Ocorrencia $ocorrencia)
    {
        $request->validate([
            'ocorrencia_id' => 'required|exists:ocorrencias,id',
            'conteudo' => 'required|string|max:1000',
        ]);

        $perspectiveKey = env('PERSPECTIVE_API_KEY');
        if ($perspectiveKey) {
            $response = Http::post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=" . $perspectiveKey, [
                "comment" => ["text" => $request['conteudo']],
                "requestedAttributes" => ["TOXICITY" => new \stdClass()],
            ]);

            $score = $response->json('attributeScores.TOXICITY.summaryScore.value');

            if ($score >= 0.7) {
                return response()->json(['message' => 'O seu comentário foi considerado inadequado e foi bloqueado.'], 422); // 422 Unprocessable Entity
            }
        }

        Comentario::create([
            'ocorrencia_id' => $request->ocorrencia_id,
            'user_id' => Auth::id(), // Isto agora funcionará, pois a rota está protegida.
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }
}