<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index(Request $request)
{
    $busca = $request->busca;

    $alunos = Aluno::query()
        ->when($busca, function ($query, $busca) {
            $query->where('nome', 'like', '%' . $busca . '%')
                  ->orWhere('matricula', 'like', '%' . $busca . '%');
        })
        ->get();

    return view('alunos.index', compact('alunos'));
}

    public function create()
    {
        return view('alunos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' => 'required|string|max:50|unique:alunos,matricula',
            'telefone' => 'nullable|string|max:100',
        ],
        [
            'matricula.unique' => 'Esta matrícula já está cadastrada' ,
        ]);

        Aluno::create($dados);

        return redirect()
            ->route('alunos.index')
            ->with('success', 'aluno criada com sucesso!');
    }

    public function search(Request $request)
    {
        $alunos = Aluno::where('nome','like','%' . $request->nome . '%')
        ->orWhere('matricula', 'like', '%' . $request->nome . '%')->get();
        return view('aluno.index', compact('alunos'));
    }

    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('alunos'));
    }

    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'matricula' =>  'required|string|max:50|unique:alunos,matricula,' . $aluno->id,
            'telefone' => 'nullable|string|max:100',
        ]);

        $aluno->update($dados);

        return redirect()
            ->route('alunos.index')
            ->with('success', 'Aluno atualizada com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()
            ->route('alunos.index')
            ->with('success', 'aluno excluída com sucesso!');
    }
}