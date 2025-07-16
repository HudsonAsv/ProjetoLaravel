<?php

use Illuminate\Support\Facades\Route; //padrão nao mexer

use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\RejeitadosController; // <-- Adicionado
use App\Http\Controllers\AnaliseController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UsuarioController;

// ROTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
    Route::get('/', [OcorrenciaController::class, 'index']);
    Route::get('/galeria', [GaleriaController::class, 'index']);
    Route::get('/ocorrencia/{id}', [GaleriaController::class, 'show']);
    Route::get('/admin/editar/{id}', [AdminController::class, 'edit']);
    Route::post('/admin/atualizar/{id}', [AdminController::class, 'update']);

    // novos dados
    Route::get('/ocorrencia/criar', [GaleriaController::class, 'create']);
    Route::post('/ocorrencia/salvar', [GaleriaController::class, 'store']);
    //Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentario.store');
    Route::post('/comentario/{ocorrencia}', [ComentarioController::class, 'store'])->middleware('auth')->name('comentario.store');


    // nova rota: página Rejeitados
    Route::get('/rejeitados', [RejeitadosController::class, 'index']);
    Route::get('/analise', [AnaliseController::class, 'index'])->name('analise');


    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
    Route::get('/perfil/editar', [UsuarioController::class, 'edit'])->name('perfil.edit');
    Route::post('/perfil', [UsuarioController::class, 'update'])->name('perfil.update');

});

// ROTAS PÚBLICAS
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $credenciais = request()->only('email', 'password');

    if (Auth::attempt($credenciais, request()->filled('remember'))) {
        return redirect()->intended('/');
    }

    return back()->with('error', 'Email ou senha inválidos');
})->name('login');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
