<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atendimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'tipo_atendimento_id',
        'usuario_id',
        'observacoes',
        'encaminhamentos',
        'data_hora',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tipoAtendimento(): BelongsTo
    {
        return $this->belongsTo(TipoAtendimento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}