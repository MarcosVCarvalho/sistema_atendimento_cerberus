<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $fillable = [
        'usuario_id',
        'acao',
        'entidade',
        'entidade_id',
        'descricao',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}