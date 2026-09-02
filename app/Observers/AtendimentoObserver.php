<?php

namespace App\Observers;

use App\Models\Atendimento;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class AtendimentoObserver
{
    public function created(Atendimento $atendimento): void
    {
        $atendimento->loadMissing([
            'paciente',
            'tipoAtendimento',
        ]);

        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'criado',
            'entidade' => 'Atendimento',
            'entidade_id' => $atendimento->id,
            'descricao' =>
                "Atendimento de {$atendimento->paciente->nome} " .
                "do tipo {$atendimento->tipoAtendimento->nome} foi criado.",
        ]);
    }

    public function updated(Atendimento $atendimento): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'atualizado',
            'entidade' => 'Atendimento',
            'entidade_id' => $atendimento->id,
            'descricao' => "Atendimento #{$atendimento->id} foi atualizado.",
        ]);
    }

    public function deleted(Atendimento $atendimento): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'excluído',
            'entidade' => 'Atendimento',
            'entidade_id' => $atendimento->id,
            'descricao' => "Atendimento #{$atendimento->id} foi excluído.",
        ]);
    }
}