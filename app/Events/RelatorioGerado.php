<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RelatorioGerado
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $dataInicio,
        public string $dataFim,
        public string $formato = 'pdf'
    ) {}
}