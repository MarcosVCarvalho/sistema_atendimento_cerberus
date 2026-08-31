<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AtendimentoController extends Controller
{
    /**
     * Lista os atendimentos.
     */
    public function index(Request $request)
    {
        $atendimentos = Atendimento::with([
            'paciente',
            'tipoAtendimento',
            'usuario',
        ])
            ->orderByDesc('data_hora')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Atendimentos/Index', [
            'atendimentos' => $atendimentos,
        ]);
    }

    /**
     * Exibe o formulário para registrar um atendimento.
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('nome')->get();

        $tipos = TipoAtendimento::orderBy('nome')->get();

        return Inertia::render('Atendimentos/Create', [
            'pacientes' => $pacientes,
            'tipos' => $tipos,
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

            'observacoes' => [
                'nullable',
                'string',
            ],

            'encaminhamentos' => [
                'nullable',
                'string',
            ],
        ]);

        // A data/hora é definida automaticamente pelo sistema.
        $dados['data_hora'] = now();

        // Se o atendimento estiver vinculado ao usuário autenticado,
        // podemos definir o usuário automaticamente.
        if (auth()->check()) {
            $dados['usuario_id'] = auth()->id();
        }

        $atendimento = Atendimento::create($dados);

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
                'sometimes',
                'exists:pacientes,id',
            ],

            'tipo_atendimento_id' => [
                'sometimes',
                'exists:tipos_atendimento,id',
            ],

            'usuario_id' => [
                'nullable',
                'exists:users,id',
            ],

            'observacoes' => [
                'nullable',
                'string',
            ],

            'encaminhamentos' => [
                'nullable',
                'string',
            ],

            'data_hora' => [
                'sometimes',
                'date',
            ],
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