<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendimentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'paciente' => $this->whenLoaded('paciente'),

            'tipo_atendimento' => $this->whenLoaded(
                'tipoAtendimento'
            ),

            'usuario' => $this->whenLoaded('usuario'),

            'observacoes' => $this->observacoes,

            'encaminhamentos' => $this->encaminhamentos,

            'data_hora' => $this->data_hora,
        ];
    }
}