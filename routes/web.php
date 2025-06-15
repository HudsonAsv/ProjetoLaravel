<?php

//use Illuminate\Support\Facades\Route; //padrão nao mexer

use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



//ROTAS PROTEGIDAS
Route::middleware('auth')->group(function () {
Route::get('/', [OcorrenciaController::class, 'index']);
Route::get('/galeria', [GaleriaController::class, 'index']);
Route::get('/ocorrencia/{id}', [GaleriaController::class, 'show']);
Route::get('/admin/editar/{id}', [AdminController::class, 'edit']);
Route::post('/admin/atualizar/{id}', [AdminController::class, 'update']);

//novos dados
Route::get('/ocorrencia/criar', [GaleriaController::class, 'create']);
Route::post('/ocorrencia/salvar', [GaleriaController::class, 'store']);
    // ... outras rotas protegidas
});




// Rotas públicas
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
