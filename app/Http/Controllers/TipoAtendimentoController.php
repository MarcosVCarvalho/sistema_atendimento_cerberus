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
    $request->merge([
        'nome' => trim($request->nome),
        'descricao' => trim($request->descricao),
    ]);

    $dados = $request->validate([
        'nome' => [
            'required',
            'string',
            'min:3',
            'max:255',
            'unique:tipos_atendimento,nome',
        ],

        'descricao' => [
            'nullable',
            'string',
            'max:255',
        ],
    ], [
        'nome.required' => 'O nome do tipo de atendimento é obrigatório.',
        'nome.min' => 'O nome deve possuir pelo menos 3 caracteres.',
        'nome.max' => 'O nome não pode ultrapassar 255 caracteres.',
        'nome.unique' => 'Este tipo de atendimento já está cadastrado.',

        'descricao.max' => 'A descrição não pode ultrapassar 255 caracteres.',
    ]);

    TipoAtendimento::create($dados);

    return redirect()
        ->route('tipos-atendimento.index')
        ->with('success', 'Tipo de atendimento cadastrado com sucesso.');
    }

    /**
     * Exibe um tipo de atendimento.
     */
    public function show(TipoAtendimento $tipos_atendimento)
    {
        return Inertia::render('TipoAtendimento/Show', [
            'tipo' => $tipos_atendimento,
        ]);
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(TipoAtendimento $tipos_atendimento)
    {
        return Inertia::render('TipoAtendimento/Edit', [
            'tipo' => $tipos_atendimento,
        ]);
    }

    /**
     * Atualiza um tipo de atendimento.
     */
    public function update(
    Request $request,
    TipoAtendimento $tipos_atendimento
    ) {
    $request->merge([
        'nome' => trim($request->nome),
        'descricao' => trim($request->descricao),
    ]);

    $dados = $request->validate([
        'nome' => [
            'required',
            'string',
            'min:3',
            'max:255',
            Rule::unique('tipos_atendimento', 'nome')
                ->ignore($tipos_atendimento->id),
        ],

        'descricao' => [
            'nullable',
            'string',
            'max:255',
        ],
    ], [
        'nome.required' => 'O nome do tipo de atendimento é obrigatório.',
        'nome.min' => 'O nome deve possuir pelo menos 3 caracteres.',
        'nome.max' => 'O nome não pode ultrapassar 255 caracteres.',
        'nome.unique' => 'Este tipo de atendimento já está cadastrado.',

        'descricao.max' => 'A descrição não pode ultrapassar 255 caracteres.',
    ]);

    $tipos_atendimento->update($dados);

    return redirect()
        ->route('tipos-atendimento.index')
        ->with('success', 'Tipo de atendimento atualizado com sucesso.');
    }

    /**
     * Remove um tipo de atendimento.
     */
    public function destroy(TipoAtendimento $tipos_atendimento)
    {
        $tipos_atendimento->delete();

        return redirect()
            ->route('tipos-atendimento.index')
            ->with('success', 'Tipo de atendimento removido com sucesso.');
    }
}