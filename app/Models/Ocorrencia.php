<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ocorrencia extends Model
{
    protected $fillable = [
        'titulo', 'descricao', 'localizacao', 'status',
        'categoria_id', 'tema_id', 'imagem'
    ];

    protected $casts = [
    'data_solicitacao' => 'datetime',
];


public function categoria()
{
    return $this->belongsTo(\App\Models\Categoria::class);
}

public function tema()
{
    return $this->belongsTo(\App\Models\Tema::class);
}

public function atualizacaos() // ou 'atualizacoes' se for o nome correto da tabela
{
    return $this->hasMany(\App\Models\Atualizacao::class);
}

public function comentarios()
{
    return $this->hasMany(Comentario::class);
}


}
