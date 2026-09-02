<?php

namespace App\Observers;

use App\Models\Paciente;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class PacienteObserver
{
    /**
     * Executado quando um paciente é cadastrado.
     */
    public function created(Paciente $paciente): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'criado',
            'entidade' => 'Paciente',
            'entidade_id' => $paciente->id,
            'descricao' => "Paciente {$paciente->nome} foi cadastrado.",
        ]);
    }

    /**
     * Executado quando um paciente é atualizado.
     */
    public function updated(Paciente $paciente): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'atualizado',
            'entidade' => 'Paciente',
            'entidade_id' => $paciente->id,
            'descricao' => "Paciente {$paciente->nome} foi atualizado.",
        ]);
    }

    /**
     * Executado quando um paciente é excluído.
     */
    public function deleted(Paciente $paciente): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'excluído',
            'entidade' => 'Paciente',
            'entidade_id' => $paciente->id,
            'descricao' => "Paciente {$paciente->nome} foi excluído.",
        ]);
    }
}