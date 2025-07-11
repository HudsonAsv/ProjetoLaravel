<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Tema;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Retorna uma lista de todas as categorias.
     */
    public function getCategorias()
    {
        // Busca todas as categorias no banco de dados, ordenadas por nome
        $categorias = Categoria::orderBy('nome')->get();
        return response()->json($categorias);
    }

    /**
     * Retorna uma lista de todos os temas.
     */
    public function getTemas()
    {
        // Busca todos os temas no banco de dados, ordenados por nome
        $temas = Tema::orderBy('nome')->get();
        return response()->json($temas);
    }
}
