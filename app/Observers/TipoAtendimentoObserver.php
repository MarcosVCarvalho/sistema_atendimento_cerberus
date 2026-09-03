<?php

namespace App\Observers;

use App\Models\TipoAtendimento;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class TipoAtendimentoObserver
{
    public function created(TipoAtendimento $tipo): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'criado',
            'entidade' => 'Tipo de Atendimento',
            'entidade_id' => $tipo->id,
            'descricao' => "Tipo de atendimento {$tipo->nome} foi criado.",
        ]);
    }

    public function updated(TipoAtendimento $tipo): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'atualizado',
            'entidade' => 'Tipo de Atendimento',
            'entidade_id' => $tipo->id,
            'descricao' => "Tipo de atendimento {$tipo->nome} foi atualizado.",
        ]);
    }

    public function deleted(TipoAtendimento $tipo): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'excluído',
            'entidade' => 'Tipo de Atendimento',
            'entidade_id' => $tipo->id,
            'descricao' => "Tipo de atendimento {$tipo->nome} foi excluído.",
        ]);
    }

    public function restored(TipoAtendimento $tipo): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'restaurado',
            'entidade' => 'Tipo de Atendimento',
            'entidade_id' => $tipo->id,
            'descricao' => "Tipo de atendimento {$tipo->nome} foi restaurado.",
        ]);
    }
}