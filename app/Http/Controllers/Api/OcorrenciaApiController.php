<?php

namespace App\Http\Controllers\Api;
use App\Models\Tema;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ocorrencia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OcorrenciaApiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            //'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'rua' => 'required|string|max:255',
            'numero' => 'nullable|string|max:50',
            'bairro' => 'required|string|max:255',
            'referencia' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'tema_id' => 'required|exists:temas,id',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🔍 Verificação de toxicidade com Perspective API
        $perspectiveKey = env('PERSPECTIVE_API_KEY');
        $textResponse = Http::post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=$perspectiveKey", [
            'comment' => ['text' => $request->descricao],
            'languages' => ['pt'],
            'requestedAttributes' => ['TOXICITY' => new \stdClass()],
        ]);
        
        $tema = Tema::find($data['tema_id']);
        $dataSolicitacao = now();
        $data['titulo'] = "Ocorrência - " . $tema->nome . " - " . $dataSolicitacao->format('d/m/Y');

        $data['status'] = 'recebido';
        $data['data_solicitacao'] = $dataSolicitacao;

        $toxicity = $textResponse->json('attributeScores.TOXICITY.summaryScore.value');
        if ($toxicity >= 0.8) {
            return response()->json(['error' => 'Conteúdo textual considerado tóxico.'], 422);
        }

        // ☑️ Upload temporário da imagem
        $imagem = $request->file('imagem');
        $path = $imagem->store('temp', 'public');
        $url = asset("storage/$path");

        // 🔍 Verificação de imagem com Sightengine
        $user = env('SIGHTENGINE_USER');
        $secret = env('SIGHTENGINE_SECRET');

        $imageCheck = Http::get('https://api.sightengine.com/1.0/check.json', [
            'url' => $url,
            'models' => 'nudity,wad,offensive',
            'api_user' => $user,
            'api_secret' => $secret,
        ]);

        if (
            $imageCheck['nudity']['raw'] > 0.7 ||
            $imageCheck['weapon'] > 0.5 ||
            $imageCheck['offensive']['prob'] > 0.7
        ) {
            Storage::disk('public')->delete($path);
            return response()->json(['error' => 'Imagem contém conteúdo impróprio.'], 422);
        }

        // 🔄 Mover a imagem do temp para pasta final
        $finalPath = $imagem->store('ocorrencias', 'public');

        // 💾 Criar ocorrência
        $ocorrencia = Ocorrencia::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'localizacao' => $request->localizacao,
            'status' => $request->status,
            'imagem' => $finalPath,
            'categoria_id' => $request->categoria_id,
            'tema_id' => $request->tema_id,
            'data_solicitacao' => now(),
        ]);

        return response()->json(['message' => 'Ocorrência salva com sucesso!', 'ocorrencia' => $ocorrencia]);
    }

    public function serveImage($filename)
    {
        $path = 'imagens/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        // Obtém o caminho completo do ficheiro no servidor
        $fullPath = Storage::disk('public')->path($path);

        // Usa a fachada 'File' para obter o mimeType do caminho completo
        $type = File::mimeType($fullPath);

        $file = Storage::disk('public')->get($path);

        return response($file, 200)->header("Content-Type", $type);
    }

}
