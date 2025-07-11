<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atualizacao extends Model
{
    //
    protected $fillable = [
    'ocorrencia_id',
    'mensagem',
    'status',
    'previsao_conclusao',
];
    public function ocorrencia()
    {
        return $this->belongsTo(Ocorrencia::class);
    }

}
