<?php

namespace App\Http\Controllers;

use App\Models\TipoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TipoAtendimentoController extends Controller
{
    /**
     * Lista os tipos de atendimento.
     */
    public function index()
    {
        $tipos = TipoAtendimento::orderBy('nome')->get();

        return Inertia::render('TipoAtendimento/Index', [
            'tipos' => $tipos,
        ]);
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return Inertia::render('TipoAtendimento/Create');
    }

    /**
     * Cadastra um novo tipo de atendimento.
     */
    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                'unique:tipos_atendimento,nome',
            ],
        ]);

        TipoAtendimento::create($dados);

        return redirect()
            ->route('tipos-atendimento.index')
            ->with('success', 'Tipo de atendimento cadastrado com sucesso.');
    }

    /**
     * Exibe um tipo de atendimento.
     */
    public function show(TipoAtendimento $tipoAtendimento)
    {
        return Inertia::render('TipoAtendimento/Show', [
            'tipo' => $tipoAtendimento,
        ]);
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(TipoAtendimento $tipoAtendimento)
    {
        return Inertia::render('TipoAtendimento/Edit', [
            'tipo' => $tipoAtendimento,
        ]);
    }

    /**
     * Atualiza um tipo de atendimento.
     */
    public function update(
        Request $request,
        TipoAtendimento $tipoAtendimento
    ) {
        $dados = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                'unique:tipos_atendimento,nome,' . $tipoAtendimento->id,
            ],
        ]);

        $tipoAtendimento->update($dados);

        return redirect()
            ->route('tipos-atendimento.index')
            ->with('success', 'Tipo de atendimento atualizado com sucesso.');
    }

    /**
     * Remove um tipo de atendimento.
     */
    public function destroy(TipoAtendimento $tipoAtendimento)
    {
        $tipoAtendimento->delete();

        return redirect()
            ->route('tipos-atendimento.index')
            ->with('success', 'Tipo de atendimento removido com sucesso.');
    }
}