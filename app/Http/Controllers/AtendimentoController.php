<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class AtendimentoController extends Controller
{
    /**
     * Lista os atendimentos.
     */
    public function index(Request $request)
{
    $busca = trim($request->input('busca', ''));

    // Tenta identificar se a busca é uma data
    $dataBusca = null;

    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $busca)) {
        try {
            $dataBusca = Carbon::createFromFormat('d/m/Y', $busca)
                ->format('Y-m-d');
        } catch (\Exception $e) {
            $dataBusca = null;
        }
    }

    $buscaCpf = preg_replace('/\D/', '', $busca);

    $atendimentos = Atendimento::query()
        ->with([
            'paciente',
            'tipoAtendimento',
            'usuario',
        ])
        ->when($busca, function ($query) use ($busca, $buscaCpf, $dataBusca) {

            $query->where(function ($q) use ($busca, $buscaCpf, $dataBusca) {

                // Paciente
                $q->whereHas('paciente', function ($paciente) use ($busca, $buscaCpf) {

                    $paciente
                        ->where('nome', 'like', "%{$busca}%")
                        ->orWhere('telefone', 'like', "%{$busca}%")
                        ->orWhere('whatsapp', 'like', "%{$busca}%");

                    if ($buscaCpf !== '') {
                        $paciente->orWhere(
                            'cpf',
                            'like',
                            "%{$buscaCpf}%"
                        );
                    }
                })

                // Tipo de atendimento
                ->orWhereHas('tipoAtendimento', function ($tipo) use ($busca) {
                    $tipo->where(
                        'nome',
                        'like',
                        "%{$busca}%"
                    );
                })

                // Observações
                ->orWhere(
                    'observacoes',
                    'like',
                    "%{$busca}%"
                )

                // Encaminhamentos
                ->orWhere(
                    'encaminhamentos',
                    'like',
                    "%{$busca}%"
                );

                // Data
                if ($dataBusca) {
                    $q->orWhereDate(
                        'data_hora',
                        $dataBusca
                    );
                }
            });
        })
        ->orderByDesc('data_hora')
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('Atendimentos/Index', [
        'atendimentos' => $atendimentos,

        'filtros' => [
            'busca' => $busca,
        ],
    ]);
}

    /**
     * Exibe o formulário para registrar um atendimento.
     */
    public function create(Request $request)
    {
    $pacientes = Paciente::orderBy('nome')->get();

    $tipos = TipoAtendimento::orderBy('nome')->get();

    return Inertia::render('Atendimentos/Create', [
        'pacientes' => $pacientes,
        'tipos' => $tipos,
        'pacienteSelecionado' => $request->paciente_id,
    ]);
    }

    /**
     * Registra um novo atendimento.
     */
    public function store(Request $request)
{
    $dados = $request->validate([
        'paciente_id' => [
            'required',
            'exists:pacientes,id',
        ],

        'tipo_atendimento_id' => [
            'required',
            'exists:tipos_atendimento,id',
        ],

        'data_hora' => [
            'required',
            'date',
        ],

        'observacoes' => [
            'nullable',
            'string',
        ],

        'encaminhamentos' => [
            'nullable',
            'string',
        ],
    ], [
        'paciente_id.required' => 'O paciente é obrigatório.',
        'paciente_id.exists' => 'O paciente selecionado não existe.',

        'tipo_atendimento_id.required' => 'O tipo de atendimento é obrigatório.',
        'tipo_atendimento_id.exists' => 'O tipo de atendimento selecionado não existe.',

        'data_hora.required' => 'A data e hora do atendimento são obrigatórias.',
        'data_hora.date' => 'A data e hora informadas são inválidas.',
    ]);

    $dados['usuario_id'] = auth()->id();

    Atendimento::create($dados);

    return redirect()
        ->route('atendimentos.index')
        ->with('success', 'Atendimento registrado com sucesso.');
}

    /**
     * Exibe um atendimento específico.
     */
    public function show(Atendimento $atendimento)
    {
        $atendimento->load([
            'paciente',
            'tipoAtendimento',
            'usuario',
        ]);

        return Inertia::render('Atendimentos/Show', [
            'atendimento' => $atendimento,
        ]);
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(Atendimento $atendimento)
    {
        $atendimento->load([
            'paciente',
            'tipoAtendimento',
            'usuario',
        ]);

        $pacientes = Paciente::orderBy('nome')->get();

        $tipos = TipoAtendimento::orderBy('nome')->get();

        return Inertia::render('Atendimentos/Edit', [
            'atendimento' => $atendimento,
            'pacientes' => $pacientes,
            'tipos' => $tipos,
        ]);
    }

    /**
     * Atualiza um atendimento.
     */
    public function update(Request $request, Atendimento $atendimento)
{
    $dados = $request->validate([
        'paciente_id' => [
            'required',
            'exists:pacientes,id',
        ],

        'tipo_atendimento_id' => [
            'required',
            'exists:tipos_atendimento,id',
        ],

        'data_hora' => [
            'required',
            'date',
        ],

        'observacoes' => [
            'nullable',
            'string',
        ],

        'encaminhamentos' => [
            'nullable',
            'string',
        ],
    ], [
        'paciente_id.required' => 'O paciente é obrigatório.',
        'paciente_id.exists' => 'O paciente selecionado não existe.',

        'tipo_atendimento_id.required' => 'O tipo de atendimento é obrigatório.',
        'tipo_atendimento_id.exists' => 'O tipo de atendimento selecionado não existe.',

        'data_hora.required' => 'A data e hora do atendimento são obrigatórias.',
        'data_hora.date' => 'A data e hora informadas são inválidas.',
    ]);

    $atendimento->update($dados);

    return redirect()
        ->route('atendimentos.index')
        ->with('success', 'Atendimento atualizado com sucesso.');
}

    /**
     * Remove um atendimento.
     */
    public function destroy(Atendimento $atendimento)
    {
        $atendimento->delete();

        return redirect()
            ->route('atendimentos.index')
            ->with('success', 'Atendimento removido com sucesso.');
    }

    /**
     * Lista os atendimentos registrados hoje.
     */
    public function hoje()
    {
        $atendimentos = Atendimento::with([
            'paciente',
            'tipoAtendimento',
            'usuario',
        ])
            ->whereDate('data_hora', today())
            ->orderBy('data_hora')
            ->get();

        return Inertia::render('Atendimentos/Hoje', [
            'data' => today()->format('d/m/Y'),
            'total' => $atendimentos->count(),
            'atendimentos' => $atendimentos,
        ]);
    }
}