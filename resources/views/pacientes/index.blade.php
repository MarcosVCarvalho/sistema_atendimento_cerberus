@extends('layouts.default')

@section('title', 'Pacientes')

@section('content')

<div class="container">

```
<!-- Cabeçalho -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="fw-bold text-dark mb-1">
            Pacientes
        </h1>

        <p class="text-muted mb-0">
            Gerencie e visualize seus pacientes.
        </p>
    </div>

    <div>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            + Novo Paciente
        </a>
    </div>

</div>

<!-- Pesquisa -->
<form
    action="{{ route('pacientes.index') }}"
    method="GET"
    class="d-flex gap-2 mb-4"
>

    <input
        type="text"
        name="busca"
        class="form-control"
        placeholder="Pesquisar por nome ou CPF..."
        value="{{ request('busca') }}"
    >

    <button type="submit" class="btn btn-primary">
        Pesquisar
    </button>

    @if(request('busca'))
        <a
            href="{{ route('pacientes.index') }}"
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
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>WhatsApp</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($pacientes as $paciente)

                        <tr>

                            <!-- Nome -->
                            <td>
                                <div class="fw-semibold">
                                    {{ $paciente->nome }}
                                </div>
                            </td>

                            <!-- CPF -->
                            <td>
                                <div class="fw-semibold">
                                    {{ $paciente->cpf }}
                                </div>
                            </td>

                            <!-- Telefone -->
                            <td>
                                <div class="fw-semibold">
                                    {{ $paciente->telefone }}
                                </div>
                            </td>

                            <!-- WhatsApp -->
                            <td>
                                <div class="fw-semibold">
                                    {{ $paciente->whatsapp }}
                                </div>
                            </td>

                            <!-- Ações -->
                            <td class="text-end">

                                <a
                                    href="{{ route('pacientes.edit', $paciente) }}"
                                    class="btn btn-sm btn-warning"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('pacientes.destroy', $paciente) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Deseja realmente excluir este paciente do sistema?')"
                                    >
                                        Excluir
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Nenhum paciente cadastrado.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
```

</div>

@endsection
