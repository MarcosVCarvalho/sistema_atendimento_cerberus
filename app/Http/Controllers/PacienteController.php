<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
{
    $busca = $request->busca;

    $pacientes = Paciente::query()
        ->when($busca, function ($query, $busca) {
            $query->where('nome', 'like', '%' . $busca . '%')->orWhere('cpf', 'like', '%' . $busca . '%');
        })->get();

    return view('pacientes.index', compact('pacientes'));
}

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:pacientes,cpf',
            'telefone' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:255',
        ],
        [
            'cpf.unique' => 'Este CPF já está cadastrado' ,
        ]);

        Paciente::create($dados);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente criado com sucesso!');
    }

    public function search(Request $request)
    {
        $pacientes = Paciente::where('nome','like','%' . $request->nome . '%')
        ->orWhere('cpf', 'like', '%' . $request->nome . '%')->get();
        return view('pacientes.index', compact('pacientes'));
    }

    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('pacientes'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Paciente $paciente)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:pacientes,cpf,' . $paciente->id,
            'telefone' => 'nullable|string|max:100',
            'whatsapp' => 'nullable|string|max:100',
            'endereco' => 'nullable|string|max:255',
        ]);

        $paciente->update($dados);

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente atualizado com sucesso!');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();

        return redirect()
            ->route('pacientes.index')
            ->with('success', 'Paciente excluído com sucesso!');
    }
}