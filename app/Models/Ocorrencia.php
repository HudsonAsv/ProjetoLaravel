<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ocorrencia extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'categoria_id',
        'tema_id',
        'imagem',
        'data_solicitacao',
        'rua',
        'numero',
        'bairro',
        'referencia',
        'latitude',
        'longitude',
        'user_id',
        'motivo_rejeicao'
    ];
public function user()
{
    return $this->belongsTo(User::class);
}

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
    return $this->hasMany(\App\Models\Comentario::class);
}


}
