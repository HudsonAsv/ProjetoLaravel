<?php

namespace App\Http\Controllers\Api;
use App\Models\Tema;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Ocorrencia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class OcorrenciaApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Ocorrencia::with(['categoria', 'tema']);
        $publicStatuses = ['em_andamento', 'concluido'];
        if ($request->has('status') && $request->status != '') {
            $requestedStatus = $request->status;
            if (in_array($requestedStatus, $publicStatuses)) {
                $query->where('status', $requestedStatus);
            } else {
                return response()->json([]);
            }
        } else {
            $query->whereIn('status', $publicStatuses);
        }
        $ocorrencias = $query->latest()->get();
        return response()->json($ocorrencias);
    }

    public function show($id)
    {
        $ocorrencia = Ocorrencia::with([
            'categoria',
            'tema',
            'user:id,name',
            'comentarios.user:id,name'
        ])->findOrFail($id);

        $authUserId = Auth::id();

        if ($ocorrencia->user_id == $authUserId) {
            //privado
            $ocorrencia->is_owner = true;
            return response()->json($ocorrencia);
        } else {
            //publico
            return response()->json([
                'is_owner' => false,
                'id' => $ocorrencia->id,
                'titulo' => $ocorrencia->titulo,
                'descricao' => $ocorrencia->descricao,
                'rua' => $ocorrencia->rua,
                'bairro' => $ocorrencia->bairro,
                'numero' => $ocorrencia->numero,
                'referencia' => $ocorrencia->referencia,
                'latitude' => $ocorrencia->latitude,
                'longitude' => $ocorrencia->longitude,
                'data_solicitacao' => $ocorrencia->data_solicitacao,
                'imagem' => $ocorrencia->imagem,
                'categoria_nome' => $ocorrencia->categoria->nome,
                'tema_nome' => $ocorrencia->tema->nome,
            ]);
        }
    }
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

        if ($request->hasFile('imagem')) {
            $user = env('SIGHTENGINE_USER');
            $secret = env('SIGHTENGINE_SECRET');

        if ($user && $secret) {
            $tempPath = $request->file('imagem')->store('temp', 'public');
            $tempUrl = Storage::url($tempPath);

            $imageCheck = Http::get('https://api.sightengine.com/1.0/check.json', [
                'url' => $tempUrl,
                'models' => 'nudity,wad,offensive',
                'api_user' => $user,
                'api_secret' => $secret,
            ]);

            Storage::disk('public')->delete($tempPath);

            if ($imageCheck->successful()) {
                $nudityScore = $imageCheck->json('nudity.raw');
                $weaponScore = $imageCheck->json('weapon');
                $offensiveScore = $imageCheck->json('offensive.prob');

            if ($nudityScore > 0.7 || $weaponScore > 0.5 || $offensiveScore > 0.7) {
                return response()->json(['message' => 'A imagem contém conteúdo impróprio.'], 422);
            }} else {
                    return response()->json(['message' => 'Não foi possível verificar a imagem. Tente novamente.'], 500);
                    //Log::error('Falha na verificação da Sightengine: ' . $imageCheck->body());
                }
            }
            $data['imagem'] = $request->file('imagem')->store('ocorrencias', 'public');
        }
        // 🔍 Verificação de toxicidade com Perspective API
        /*$perspectiveKey = env('PERSPECTIVE_API_KEY');
        $textResponse = Http::post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=$perspectiveKey", [
            'comment' => ['text' => $request->descricao],
            'languages' => ['pt'],
            'requestedAttributes' => ['TOXICITY' => new \stdClass()],
        ]);
        $toxicity = $textResponse->json('attributeScores.TOXICITY.summaryScore.value');
        if ($toxicity >= 0.8) {
            return response()->json(['error' => 'Conteúdo textual considerado tóxico.'], 422);
        }

        $imagem = $request->file('imagem');
        $path = $imagem->store('temp', 'public');
        $url = asset("storage/$path");

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

        $finalPath = $imagem->store('ocorrencias', 'public');*/

        $tema = Tema::find($data['tema_id']);
        $dataSolicitacao = now();
        $data['titulo'] = "Ocorrência - " . $tema->nome . " - " . $dataSolicitacao->format('d/m/Y');
        $data['status'] = 'recebido';
        $data['data_solicitacao'] = $dataSolicitacao;
        $data['user_id'] = Auth::id();

        $ocorrencia = Ocorrencia::create($data);
        return response()->json(['message' => 'Ocorrência salva com sucesso!', 'ocorrencia' => $ocorrencia], 201);
    }
        public function minhasOcorrencias(Request $request)
    {
        $userId = Auth::id();
        $ocorrencias = Ocorrencia::where('user_id', $userId)
                                  ->with(['categoria', 'tema', 'user:id,name'])
                                  ->latest()
                                  ->get();
        return response()->json($ocorrencias);
    }
    public function serveImage($filename)
    {
        $path = 'imagens/' . $filename;
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
        $fullPath = Storage::disk('public')->path($path);
        $type = File::mimeType($fullPath);
        $file = Storage::disk('public')->get($path);
        return response($file, 200)->header("Content-Type", $type);
    }

}
