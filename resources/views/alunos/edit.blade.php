@extends('layouts.default')

@section('title', 'Editar Aluno')

@section('content')

<div class="container">


{{-- Cabeçalho --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="fw-bold text-dark mb-1">
            Editar Aluno
        </h1>

        <p class="text-muted mb-0">
            Altere os dados do aluno.
        </p>
    </div>

    <a href="{{ route('alunos.index') }}" class="btn btn-secondary">
        ← Voltar
    </a>

</div>


{{-- Mensagem de erro geral --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Verifique os seguintes erros:</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- Formulário --}}
<div class="card shadow-sm border-0">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            Dados do aluno
        </h5>
    </div>

    <div class="card-body">

        <form
            action="{{ route('alunos.update', $aluno) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- Nome --}}
            <div class="mb-3">

                <label for="nome" class="form-label fw-semibold">
                    Nome completo
                </label>

                <input
                    type="text"
                    name="nome"
                    id="nome"
                    class="form-control @error('nome') is-invalid @enderror"
                    value="{{ old('nome', $aluno->nome) }}"
                    placeholder="Ex: João da Silva"
                    required
                    autofocus
                >

                @error('nome')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Matrícula --}}
            <div class="mb-3">

                <label for="matricula" class="form-label fw-semibold">
                    Matrícula
                </label>

                <input
                    type="text"
                    name="matricula"
                    id="matricula"
                    class="form-control @error('matricula') is-invalid @enderror"
                    value="{{ old('matricula', $aluno->matricula) }}"
                    placeholder="Ex: 2026001234"
                    required
                >

                @error('matricula')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Telefone --}}
            <div class="mb-4">

                <label for="telefone" class="form-label fw-semibold">
                    Telefone
                </label>

                <input
                    type="text"
                    name="telefone"
                    id="telefone"
                    class="form-control @error('telefone') is-invalid @enderror"
                    value="{{ old('telefone', $aluno->telefone) }}"
                    placeholder="Ex: (88) 9 8888-8888"
                >

                @error('telefone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Botões --}}
            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('alunos.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Salvar alterações
                </button>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
