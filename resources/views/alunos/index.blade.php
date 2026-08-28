@extends('layouts.default')

@section('title', 'Alunos')

@section('content')

<div class="container">

    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold text-dark mb-1">
                Alunos
            </h1>

            <p class="text-muted mb-0">
                Gerencie e visualize seus alunos.
            </p>
        </div>

        <div>
            <a href="{{ route('alunos.create') }}" class="btn btn-primary">
                + Novo Aluno
            </a>
        </div>

    </div>

    <!-- pesquisa -->
    <form
    action="{{ route('alunos.index') }}"
    method="GET"
    class="d-flex gap-2"
>

    <input
        type="text"
        name="busca"
        class="form-control"
        placeholder="Pesquisar por nome ou matrícula..."
        value="{{ request('busca') }}"
    >

    <button type="submit" class="btn btn-primary">
        Pesquisar
    </button>

    @if(request('busca'))
        <a
            href="{{ route('alunos.index') }}"
            class="btn btn-secondary"
        >
            Limpar
        </a>
    @endif

    </form>


    <!-- Card -->
    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Matricula</th>
                            <th>Telefone</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($alunos as $aluno)

                            <tr>

                                <!-- Nome -->
                                <td>
                                    <div class="fw-semibold">
                                        {{ $aluno->nome }}
                                    </div>
                                </td>


                                <!-- matricula -->
                                <td>
                                    <div class="fw-semibold">
                                        {{ $aluno->matricula }}
                                    </div>
                                </td>


                                <!-- telefone -->
                                <td>
                                    <div class="fw-semibold">
                                        {{ $aluno->telefone }}
                                    </div>
                                </td>



                                <!-- Ações -->
                                <td class="text-end">

                                    <a
                                        href="{{ route('alunos.edit', $aluno) }}"
                                        class="btn btn-sm btn-warning">
                                        Editar
                                    </a>


                                    <form
                                        action="{{ route('alunos.destroy', $aluno) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Deseja realmente excluir este aluno do sistema?')">

                                            Excluir

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">

                                    Nenhum aluno cadastrado.

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection