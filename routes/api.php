<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OcorrenciaApiController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\ComentarioController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/categorias', [DataController::class, 'getCategorias']);
Route::get('/temas', [DataController::class, 'getTemas']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/ocorrencias', [OcorrenciaApiController::class, 'index']);
    Route::get('/ocorrencias/{id}', [OcorrenciaApiController::class, 'show']);
    Route::post('/ocorrencias', [OcorrenciaApiController::class, 'store']);
    Route::get('/minhas-ocorrencias', [OcorrenciaApiController::class, 'minhasOcorrencias']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/ocorrencias/{ocorrencia}/comentarios', [ComentarioController::class, 'index']);
    Route::post('/ocorrencias/{ocorrencia}/comentarios', [ComentarioController::class, 'store']);
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
});

Route::get('/images/{filename}', function ($filename) {
    $path = 'ocorrencias/' . $filename;

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $fullPath = Storage::disk('public')->path($path);

    $type = File::mimeType($fullPath);

    $file = Storage::disk('public')->get($path);

    return response($file, 200)
        ->header('Content-Type', $type);
})->where('filename', '.*');
