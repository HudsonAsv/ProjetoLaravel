<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Tema;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getCategorias()
    {
        $categorias = Categoria::orderBy('nome')->get();
        return response()->json($categorias);
    }

    public function getTemas()
    {
        $temas = Tema::orderBy('nome')->get();
        return response()->json($temas);
    }
}
