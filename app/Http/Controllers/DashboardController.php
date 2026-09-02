<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Paciente;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de pacientes cadastrados
        $totalPacientes = Paciente::count();

        // Atendimentos registrados hoje
        $atendimentosHoje = Atendimento::whereDate(
            'data_hora',
            today()
        )->count();

        // Atendimentos de hoje
        $atendimentos = Atendimento::with([
            'paciente',
            'tipoAtendimento',
            'usuario',
        ])
            ->whereDate('data_hora', today())
            ->orderBy('data_hora')
            ->get();

        // Total de atendimentos pendentes
        $pendentes = 0;

        return Inertia::render('Dashboard', [
            'estatisticas' => [
                'pacientes' => $totalPacientes,
                'atendimentosHoje' => $atendimentosHoje,
                'pendentes' => $pendentes,
            ],

            'atendimentos' => $atendimentos,
        ]);
    }
}
