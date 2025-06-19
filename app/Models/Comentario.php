<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = ['ocorrencia_id', 'autor', 'mensagem'];

public function ocorrencia()
{
    return $this->belongsTo(Ocorrencia::class);
}

}
