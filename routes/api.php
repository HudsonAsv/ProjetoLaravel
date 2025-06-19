<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OcorrenciaApiController;

Route::get('ocorrencias', [OcorrenciaApiController::class, 'index']);
Route::get('ocorrencias/{id}', [OcorrenciaApiController::class, 'show']);
Route::post('ocorrencias', [OcorrenciaApiController::class, 'store']);
