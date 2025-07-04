<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OcorrenciaApiController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('ocorrencias', [OcorrenciaApiController::class, 'index']);
Route::get('ocorrencias/{id}', [OcorrenciaApiController::class, 'show']);
Route::post('ocorrencias', [OcorrenciaApiController::class, 'store']);

Route::get('/images/{filename}', function ($filename) {
    $path = storage_path('app/public/images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('filename', '.*');
