<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Comentario;
use App\Models\Ocorrencia;

class ComentarioController extends Controller
{
    public function index(Ocorrencia $ocorrencia)
    {
        $comentarios = $ocorrencia->comentarios()->with('user:id,name')->latest()->get();
        return response()->json($comentarios);
    }

    /*public function store(Request $request, $ocorrenciaId)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000',
        ]);

        // Chamada à Perspective API
        $response = Http::withOptions([
            'verify' => false,
        ])->post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=" . env('PERSPECTIVE_API_KEY'), [
            "comment" => ["text" => $request->conteudo],
            "requestedAttributes" => [
                "TOXICITY" => new \stdClass(),
                "INSULT" => new \stdClass(),
                "PROFANITY" => new \stdClass(),
                "THREAT" => new \stdClass(),
            ],
        ]);

        // Verificação de toxicidade
        $score = $response['attributeScores']['TOXICITY']['summaryScore']['value'] ?? 0;

        if ($score >= 0.7) {
            return back()->withErrors(['conteudo' => 'Comentário considerado ofensivo e foi bloqueado.']);
        }

        // Criação do comentário
        Comentario::create([
            'ocorrencia_id' => $ocorrenciaId,
            'user_id' => Auth::id(),
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }*/

    public function store(Request $request, Ocorrencia $ocorrencia)
    {
        $validatedData = $request->validate([
            'conteudo' => 'required|string|max:1000',
        ]);
        
        $perspectiveKey = env('PERSPECTIVE_API_KEY');
        if ($perspectiveKey) {
            $response = Http::post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=" . $perspectiveKey, [
                "comment" => ["text" => $validatedData['conteudo']],
                "requestedAttributes" => ["TOXICITY" => new \stdClass()],
            ]);

            $score = $response->json('attributeScores.TOXICITY.summaryScore.value');

            if ($score >= 0.7) {
                return response()->json(['message' => 'O seu comentário foi considerado inadequado e foi bloqueado.'], 422);
            }
        }

        $comentario = $ocorrencia->comentarios()->create([
            'conteudo' => $validatedData['conteudo'],
            'user_id' => Auth::id(),
        ]);

        $comentario->load('user:id,name');

        return response()->json($comentario, 201);
    }
}
