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

        $moderationStatus = 'recebido';
        $rejectionReason = null;

        $perspectiveKey = env('PERSPECTIVE_API_KEY');
        if ($perspectiveKey) {
            $textResponse = Http::post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=$perspectiveKey", [
                'comment' => ['text' => $data['descricao']],
                'languages' => ['pt'],
                'requestedAttributes' => ['TOXICITY' => new \stdClass()],
            ]);
            $toxicity = $textResponse->json('attributeScores.TOXICITY.summaryScore.value');

            if ($toxicity >= env('PERSPECTIVE_REJECT_THRESHOLD', 0.7)) {
                $moderationStatus = 'rejeitado';
                $rejectionReason = 'Conteúdo textual considerado altamente inadequado.';
            } elseif ($toxicity >= env('PERSPECTIVE_REVIEW_THRESHOLD', 0.5)) {
                $moderationStatus = 'em_analise';
                $rejectionReason = 'Conteúdo textual sinalizado para revisão.';
            }
        }

        if ($moderationStatus !== 'rejeitado' && $request->hasFile('imagem')) {
            $user = env('SIGHTENGINE_USER');
            $secret = env('SIGHTENGINE_SECRET');

            if ($user && $secret) {
                $imageCheck = Http::asMultipart()->post('https://api.sightengine.com/1.0/check.json', [
                    ['name' => 'media', 'contents' => fopen($request->file('imagem')->getPathname(), 'r')],
                    ['name' => 'models', 'contents' => 'nudity,wad,offensive'],
                    ['name' => 'api_user', 'contents' => $user],
                    ['name' => 'api_secret', 'contents' => $secret],
                ]);

                if ($imageCheck->successful()) {
                    $rawNudityScore = $imageCheck->json('nudity.raw');
                    $partialNudityScore = $imageCheck->json('nudity.partial');
                    $weaponScore = $imageCheck->json('weapon');

                    if ($rawNudityScore > env('SIGHTENGINE_REJECT_THRESHOLD', 0.85) || $weaponScore > env('SIGHTENGINE_REJECT_THRESHOLD', 0.85)) {
                        $moderationStatus = 'rejeitado';
                        $rejectionReason = 'A imagem contém conteúdo altamente impróprio.';
                    }
                    elseif ($partialNudityScore > env('SIGHTENGINE_REVIEW_THRESHOLD', 0.6)) {
                        if ($moderationStatus !== 'em_analise') {
                            $moderationStatus = 'em_analise';
                            $rejectionReason = 'A imagem foi sinalizada para revisão.';
                        }
                    }
                }
            }
        }

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('ocorrencias', 'public');
        }

        $tema = Tema::find($data['tema_id']);
        $dataSolicitacao = now();
        $data['titulo'] = "Ocorrência - " . $tema->nome . " - " . $dataSolicitacao->format('d/m/Y');
        $data['data_solicitacao'] = $dataSolicitacao;
        $data['user_id'] = Auth::id();

        $data['status'] = $moderationStatus;
        $data['motivo_rejeicao'] = $rejectionReason;

        $ocorrencia = Ocorrencia::create($data);

        if ($moderationStatus === 'em_analise' || $moderationStatus === 'rejeitado') {
             return response()->json(['message' => 'A sua ocorrência foi recebida e está em processo de moderação.'], 202); // 202 Accepted
        }

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
