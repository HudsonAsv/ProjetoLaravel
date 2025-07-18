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

        $score = $response['attributeScores']['TOXICITY']['summaryScore']['value'] ?? 0;

        if ($score >= 0.7) {
            return back()->withErrors(['conteudo' => 'Comentário considerado ofensivo foi bloqueado.']);
        }

        Comentario::create([
            'ocorrencia_id' => $ocorrenciaId,
            'user_id' => Auth::id(),
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }*/

    public function store(Request $request, Ocorrencia $ocorrencia)
    {
        $request->validate([
            'ocorrencia_id' => 'required|exists:ocorrencias,id',
            'conteudo' => 'required|string|max:1000',
        ]);

        $perspectiveKey = env('PERSPECTIVE_API_KEY');
        $isToxic = false;

        if ($perspectiveKey) {
            $response = Http::post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=" . $perspectiveKey, [
                "comment" => ["text" => $request->conteudo],
                "languages" => ["pt"],
                "requestedAttributes" => ["TOXICITY" => new \stdClass()],
            ]);

            if ($response->successful()) {
                $score = $response->json('attributeScores.TOXICITY.summaryScore.value');
                if ($score >= 0.6) {
                    $isToxic = true;
                }
            } else {
                $errorMessage = $response->json('error.message', '');
                if (!str_contains($errorMessage, 'does not support request languages')) {
                    // Log::error('Erro inesperado da Perspective API: ' . $errorMessage);
                }
            }
        }
        if ($isToxic) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['conteudo' => 'O seu comentário foi considerado inadequado e foi bloqueado.']);
        }

        Comentario::create([
            'ocorrencia_id' => $request->ocorrencia_id,
            'user_id' => Auth::id(),
            'conteudo' => $request->conteudo,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }
}
