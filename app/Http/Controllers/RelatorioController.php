<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Events\RelatorioGerado;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $dataInicio = $request->input(
            'data_inicio',
            now()->startOfMonth()->format('Y-m-d')
        );

        $dataFim = $request->input(
            'data_fim',
            now()->endOfMonth()->format('Y-m-d')
        );

        $inicio = Carbon::parse($dataInicio)->startOfDay();
        $fim = Carbon::parse($dataFim)->endOfDay();

        $baseQuery = Atendimento::query()
            ->whereBetween('data_hora', [$inicio, $fim]);

        $total = (clone $baseQuery)->count();

        $pacientes = (clone $baseQuery)
            ->distinct('paciente_id')
            ->count('paciente_id');

        $tipos = (clone $baseQuery)
            ->distinct('tipo_atendimento_id')
            ->count('tipo_atendimento_id');

        $usuarios = (clone $baseQuery)
            ->distinct('usuario_id')
            ->count('usuario_id');

        // Por tipo
        $porTipo = (clone $baseQuery)
            ->selectRaw('tipo_atendimento_id, COUNT(*) as quantidade')
            ->with('tipoAtendimento:id,nome')
            ->groupBy('tipo_atendimento_id')
            ->orderByDesc('quantidade')
            ->get()
            ->map(function ($item) use ($total) {
                return [
                    'id' => $item->tipo_atendimento_id,
                    'nome' => $item->tipoAtendimento?->nome ?? 'Não informado',
                    'quantidade' => $item->quantidade,
                    'porcentagem' => $total > 0
                        ? round(($item->quantidade / $total) * 100, 1)
                        : 0,
                ];
            });

        // Por usuário
        $porUsuario = (clone $baseQuery)
            ->selectRaw('usuario_id, COUNT(*) as quantidade')
            ->with('usuario:id,name')
            ->groupBy('usuario_id')
            ->orderByDesc('quantidade')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->usuario_id,
                    'nome' => $item->usuario?->name ?? 'Não informado',
                    'quantidade' => $item->quantidade,
                ];
            });

        // Por dia
        $porDia = (clone $baseQuery)
            ->selectRaw('DATE(data_hora) as data, COUNT(*) as quantidade')
            ->groupByRaw('DATE(data_hora)')
            ->orderBy('data')
            ->get()
            ->map(function ($item) {
                return [
                    'data' => Carbon::parse($item->data)->format('d/m'),
                    'quantidade' => $item->quantidade,
                ];
            });

        return Inertia::render('Relatorios/Index', [
            'filtros' => [
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFim,
            ],

            'resumo' => [
                'total' => $total,
                'pacientes' => $pacientes,
                'tipos' => $tipos,
                'usuarios' => $usuarios,
            ],

            'porTipo' => $porTipo,
            'porUsuario' => $porUsuario,
            'porDia' => $porDia,
        ]);
    }

    public function pdf(Request $request)
    {
        $dataInicio = $request->input(
            'data_inicio',
            now()->startOfMonth()->format('Y-m-d')
        );

        $dataFim = $request->input(
            'data_fim',
            now()->endOfMonth()->format('Y-m-d')
        );

        $inicio = Carbon::parse($dataInicio)->startOfDay();
        $fim = Carbon::parse($dataFim)->endOfDay();

        $baseQuery = Atendimento::query()
            ->whereBetween('data_hora', [$inicio, $fim]);

        $total = (clone $baseQuery)->count();

        $pacientes = (clone $baseQuery)
            ->distinct('paciente_id')
            ->count('paciente_id');

        $tipos = (clone $baseQuery)
            ->distinct('tipo_atendimento_id')
            ->count('tipo_atendimento_id');

        $usuarios = (clone $baseQuery)
            ->distinct('usuario_id')
            ->count('usuario_id');

        // Atendimentos por tipo
        $porTipo = (clone $baseQuery)
            ->selectRaw('tipo_atendimento_id, COUNT(*) as quantidade')
            ->with('tipoAtendimento:id,nome')
            ->groupBy('tipo_atendimento_id')
            ->orderByDesc('quantidade')
            ->get()
            ->map(function ($item) use ($total) {
                return [
                    'nome' => $item->tipoAtendimento?->nome ?? 'Não informado',
                    'quantidade' => $item->quantidade,
                    'porcentagem' => $total > 0
                        ? round(($item->quantidade / $total) * 100, 1)
                        : 0,
                ];
            });

        // Atendimentos por usuário
        $porUsuario = (clone $baseQuery)
            ->selectRaw('usuario_id, COUNT(*) as quantidade')
            ->with('usuario:id,name')
            ->groupBy('usuario_id')
            ->orderByDesc('quantidade')
            ->get()
            ->map(function ($item) {
                return [
                    'nome' => $item->usuario?->name ?? 'Não informado',
                    'quantidade' => $item->quantidade,
                ];
            });

        // Atendimentos por dia
        $porDia = (clone $baseQuery)
            ->selectRaw('DATE(data_hora) as data, COUNT(*) as quantidade')
            ->groupByRaw('DATE(data_hora)')
            ->orderBy('data')
            ->get()
            ->map(function ($item) {
                return [
                    'data' => Carbon::parse($item->data)->format('d/m/Y'),
                    'quantidade' => $item->quantidade,
                ];
            });

        $pdf = Pdf::loadView('relatorios.pdf', [
            'dataInicio' => $inicio,
            'dataFim' => $fim,

            'resumo' => [
                'total' => $total,
                'pacientes' => $pacientes,
                'tipos' => $tipos,
                'usuarios' => $usuarios,
            ],

            'porTipo' => $porTipo,
            'porUsuario' => $porUsuario,
            'porDia' => $porDia,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $nomeArquivo =
            'relatorio-atendimentos-' .
            $inicio->format('Y-m-d') .
            '-a-' .
            $fim->format('Y-m-d') .
            '.pdf';

        // Dispara o evento de relatório gerado
        RelatorioGerado::dispatch(
            $inicio->format('Y-m-d'),
            $fim->format('Y-m-d'),
            'pdf'
        );    

        return $pdf->stream($nomeArquivo);
    }
}