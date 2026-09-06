<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Events\RelatorioGerado;
use App\Models\Paciente;

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
    $cidade = trim($request->input('cidade', ''));
    $bairro = trim($request->input('bairro', ''));

    $baseQuery = Atendimento::query()
    ->whereBetween('data_hora', [$inicio, $fim])
    ->when($cidade, function ($query) use ($cidade) {
        $query->whereHas('paciente', function ($paciente) use ($cidade) {
            $paciente->where('cidade', 'like', "%{$cidade}%");
        });
    })
    ->when($bairro, function ($query) use ($bairro) {
        $query->whereHas('paciente', function ($paciente) use ($bairro) {
            $paciente->where('bairro', 'like', "%{$bairro}%");
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Resumo
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Por tipo
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Por usuário
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Por dia
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Por bairro
    |--------------------------------------------------------------------------
    */

    $porBairro = (clone $baseQuery)
    ->join(
        'pacientes',
        'atendimentos.paciente_id',
        '=',
        'pacientes.id'
    )
    ->selectRaw("
        COALESCE(
            NULLIF(TRIM(pacientes.bairro), ''),
            'Não informado'
        ) as bairro,
        COUNT(*) as quantidade
    ")
    ->groupBy('bairro')
    ->orderByDesc('quantidade')
    ->get()
    ->map(function ($item) {
        return [
            'bairro' => $item->bairro,
            'quantidade' => $item->quantidade,
        ];
    });


    /*
    |--------------------------------------------------------------------------
    | Por cidade
    |--------------------------------------------------------------------------
    */

    $porCidade = (clone $baseQuery)
    ->join(
        'pacientes',
        'atendimentos.paciente_id',
        '=',
        'pacientes.id'
    )
    ->selectRaw("
        COALESCE(
            NULLIF(TRIM(pacientes.cidade), ''),
            'Não informado'
        ) as cidade,
        COUNT(*) as quantidade
    ")
    ->groupBy('cidade')
    ->orderByDesc('quantidade')
    ->get()
    ->map(function ($item) {
        return [
            'cidade' => $item->cidade,
            'quantidade' => $item->quantidade,
        ];
    });


    $cidades = Paciente::query()
    ->whereNotNull('cidade')
    ->where('cidade', '!=', '')
    ->select('cidade')
    ->distinct()
    ->orderBy('cidade')
    ->pluck('cidade');

$bairros = Paciente::query()
    ->whereNotNull('bairro')
    ->where('bairro', '!=', '')
    ->select('bairro', 'cidade')
    ->distinct()
    ->orderBy('bairro')
    ->get();

/*
|--------------------------------------------------------------------------
| Retorno
|--------------------------------------------------------------------------
*/

return Inertia::render('Relatorios/Index', [
    'filtros' => [
        'data_inicio' => $dataInicio,
        'data_fim' => $dataFim,
        'cidade' => $cidade,
        'bairro' => $bairro,
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
    'porBairro' => $porBairro,
    'porCidade' => $porCidade,

    // Opções para os selects
    'cidades' => $cidades,
    'bairros' => $bairros,
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

        $porBairro = (clone $baseQuery)
            ->join('pacientes', 'atendimentos.paciente_id', '=', 'pacientes.id')
            ->selectRaw('pacientes.bairro, COUNT(*) as quantidade')
            ->groupBy('pacientes.bairro')
            ->orderByDesc('quantidade')
            ->get()
            ->map(function ($item) {
                return [
                    'bairro' => $item->bairro,
                    'quantidade' => $item->quantidade,
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