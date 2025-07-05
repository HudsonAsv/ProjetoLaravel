<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use Illuminate\Support\Facades\Http;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ocorrencia_id' => 'required|exists:ocorrencias,id',
            'autor' => 'required|string|max:100',
            'mensagem' => 'required|string|max:1000',
        ]);

        // Chamada à Perspective API
        
$response = Http::withOptions([
    'verify' => false, // Desativa verificação do certificado SSL
])->post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=" . env('PERSPECTIVE_API_KEY'), [
    "comment" => ["text" => $request->mensagem],
    "requestedAttributes" => ["TOXICITY" => new \stdClass()],
]);

        // Extrai o score de toxicidade
        $score = $response['attributeScores']['TOXICITY']['summaryScore']['value'] ?? 0;

        // Bloqueia se score for alto
        if ($score >= 0.7) {
            return back()->withErrors(['mensagem' => 'Comentário considerado ofensivo e foi bloqueado.']);
        }

        Comentario::create([
            'ocorrencia_id' => $request->ocorrencia_id,
            'autor' => $request->autor,
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }
}
