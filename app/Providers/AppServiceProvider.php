<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Paciente;
use App\Models\Atendimento;
use App\Observers\PacienteObserver;
use App\Observers\AtendimentoObserver;
use App\Events\RelatorioGerado;
use App\Listeners\RegistrarRelatorioGerado;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paciente::observe(PacienteObserver::class);

        Atendimento::observe(AtendimentoObserver::class);

        Event::listen(
            RelatorioGerado::class,
            RegistrarRelatorioGerado::class
        );
    }
}