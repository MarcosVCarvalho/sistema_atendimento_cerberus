<?php

namespace App\Listeners;

use App\Events\RelatorioGerado;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

class RegistrarRelatorioGerado
{
    public function handle(RelatorioGerado $event): void
    {
        Auditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => 'relatório',
            'entidade' => 'Relatório',
            'entidade_id' => null,
            'descricao' =>
                "Relatório de atendimentos em {$event->formato} " .
                "gerado no período de {$event->dataInicio} " .
                "a {$event->dataFim}.",
        ]);
    }
}