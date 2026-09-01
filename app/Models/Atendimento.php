<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\TipoAtendimento;
use App\Models\Paciente;
use App\Models\User;

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

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(
            Paciente::class,
            'paciente_id'
        );
    }

    public function tipoAtendimento(): BelongsTo
    {
        return $this->belongsTo(
            TipoAtendimento::class,
            'tipo_atendimento_id'
        );
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }
}
