<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoAtendimento extends Model
{
    use HasFactory;
    use SoftDeletes;
    

    protected $table = 'tipos_atendimento';

    protected $fillable = [
        'nome',
        'descricao',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Um tipo de atendimento pode estar associado
     * a vários atendimentos.
     */
    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class);
    }
}