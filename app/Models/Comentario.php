<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = ['ocorrencia_id', 'user_id', 'conteudo'];

public function ocorrencia()
{
    return $this->belongsTo(Ocorrencia::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}


}
