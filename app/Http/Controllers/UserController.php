<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
                'role',
                'created_at',
            ]);

        return Inertia::render('Usuarios/Index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function create()
    {
        return Inertia::render('Usuarios/Create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve possuir pelo menos 3 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'role.required' => 'Selecione o nível de acesso.',
            'role.in' => 'Nível de acesso inválido.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve possuir pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        $dados['password'] = bcrypt($dados['password']);

        User::create($dados);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function edit(User $usuario)
    {
        return Inertia::render('Usuarios/Edit', [
            'usuario' => $usuario->only([
                'id',
                'name',
                'email',
                'role',
            ]),
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve possuir pelo menos 3 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'role.required' => 'Selecione o nível de acesso.',
            'password.min' => 'A senha deve possuir pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        if (empty($dados['password'])) {
            unset($dados['password']);
        } else {
            $dados['password'] = bcrypt($dados['password']);
        }

        $usuario->update($dados);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'Você não pode excluir seu próprio usuário.');
        }

        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}