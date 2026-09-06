<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Paciente extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'whatsapp',
        'rua',
        'bairro',
        'cidade',
    ];

    /**
     * Um paciente pode possuir vários atendimentos.
     */
    public function atendimentos(): HasMany
    {
        return $this->hasMany(Atendimento::class);
    }

    protected function bairro(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value
                ? mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8')
                : null
        );
    }

    protected function cidade(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value
                ? mb_convert_case(trim($value), MB_CASE_TITLE, 'UTF-8')
                : null
        );
    }
}