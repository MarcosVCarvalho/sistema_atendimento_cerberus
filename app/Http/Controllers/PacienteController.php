<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\ValidCpf;
use Inertia\Inertia;


class PacienteController extends Controller
{
    /**
     * Lista e pesquisa pacientes.
     */
    public function index(Request $request)
    {
    $busca = $request->input('busca');

    $buscaCpf = preg_replace('/\D/', '', $busca ?? '');

    $pacientes = Paciente::query()
        ->when($busca, function ($query) use ($busca, $buscaCpf) {

            $query->where(function ($q) use ($busca, $buscaCpf) {

                $q->where('nome', 'like', "%{$busca}%")
                    ->orWhere('telefone', 'like', "%{$busca}%")
                    ->orWhere('whatsapp', 'like', "%{$busca}%");

                if ($buscaCpf !== '') {
                    $q->orWhere('cpf', 'like', "%{$buscaCpf}%");
                }

            });
        })
        ->orderBy('nome')
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('Pacientes/Index', [
        'pacientes' => $pacientes,
        'filtros' => [
            'busca' => $busca,
        ],
    ]);
    }

    /**
     * Exibe formulário de cadastro.
     */
    public function create()
    {
        return Inertia::render('Pacientes/Create');
    }

    /**
     * Cadastra um novo paciente.
     */
    public function store(Request $request)
{
    $request->merge([
        'nome' => trim($request->nome),
        'cpf' => preg_replace('/\D/', '', $request->cpf),
        'telefone' => preg_replace('/\D/', '', $request->telefone),
        'whatsapp' => preg_replace('/\D/', '', $request->whatsapp),
        'endereco' => trim($request->endereco),
    ]);

    $dados = $request->validate([
        'nome' => [
            'required',
            'string',
            'min:3',
            'max:255',
        ],

        'cpf' => [
            'required',
            'string',
            new ValidCpf,
            'unique:pacientes,cpf',
        ],

        'telefone' => [
            'nullable',
            'regex:/^\d{10,11}$/',
        ],

        'whatsapp' => [
            'nullable',
            'regex:/^\d{10,11}$/',
        ],

        'endereco' => [
            'nullable',
            'string',
            'max:255',
        ],
    ], [
        'nome.required' => 'O nome do paciente é obrigatório.',
        'nome.min' => 'O nome deve possuir pelo menos 3 caracteres.',
        'nome.max' => 'O nome não pode ultrapassar 255 caracteres.',

        'cpf.required' => 'O CPF é obrigatório.',
        'cpf.unique' => 'Este CPF já está cadastrado no sistema.',

        'telefone.regex' => 'O telefone informado é inválido.',
        'whatsapp.regex' => 'O WhatsApp informado é inválido.',

        'endereco.max' => 'O endereço não pode ultrapassar 255 caracteres.',
    ]);

    Paciente::create($dados);

    return redirect()
        ->route('pacientes.index')
        ->with('success', 'Paciente cadastrado com sucesso.');
}

    /**
     * Exibe um paciente.
     */
    public function show(Paciente $paciente)
    {
        return Inertia::render('Pacientes/Show', [
            'paciente' => $paciente,
        ]);
    }

    /**
     * Exibe formulário de edição.
     */
    public function edit(Paciente $paciente)
    {
        return Inertia::render('Pacientes/Edit', [
            'paciente' => $paciente,
        ]);
    }

    /**
     * Atualiza um paciente.
     */
    public function update(Request $request, Paciente $paciente)
{
    $request->merge([
        'nome' => trim($request->nome),
        'cpf' => preg_replace('/\D/', '', $request->cpf),
        'telefone' => preg_replace('/\D/', '', $request->telefone),
        'whatsapp' => preg_replace('/\D/', '', $request->whatsapp),
        'endereco' => trim($request->endereco),
    ]);

    $dados = $request->validate([
        'nome' => [
            'required',
            'string',
            'min:3',
            'max:255',
        ],

        'cpf' => [
            'required',
            'string',
            new ValidCpf,
            Rule::unique('pacientes', 'cpf')
                ->ignore($paciente->id),
        ],

        'telefone' => [
            'nullable',
            'regex:/^\d{10,11}$/',
        ],

        'whatsapp' => [
            'nullable',
            'regex:/^\d{10,11}$/',
        ],

        'endereco' => [
            'nullable',
            'string',
            'max:255',
        ],
    ], [
        'nome.required' => 'O nome do paciente é obrigatório.',
        'nome.min' => 'O nome deve possuir pelo menos 3 caracteres.',
        'nome.max' => 'O nome não pode ultrapassar 255 caracteres.',
        'cpf.required' => 'O CPF é obrigatório.',
        'cpf.unique' => 'Este CPF já está cadastrado no sistema.',
        'telefone.regex' => 'O telefone informado é inválido.',
        'whatsapp.regex' => 'O WhatsApp informado é inválido.',
        'endereco.max' => 'O endereço não pode ultrapassar 255 caracteres.',
    ]);

    $paciente->update($dados);

    return redirect()
        ->route('pacientes.ficha', $paciente)
        ->with('success', 'Paciente atualizado com sucesso.');
}

    /**
     * Remove um paciente.
     */
    public function destroy(Paciente $paciente)
    {   
        $paciente->delete();

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente removido com sucesso.');
    }

    /**
     * Exibe a ficha completa do paciente.
     */
    public function ficha(Paciente $paciente)
    {
    $paciente->load([
        'atendimentos' => function ($query) {
            $query->with([
                'tipoAtendimento',
                'usuario',
            ])
            ->orderByDesc('data_hora');
        },
    ]);

    return Inertia::render('Pacientes/Ficha', [
        'paciente' => $paciente,
        'historico' => $paciente->atendimentos,
    ]);
    }

}