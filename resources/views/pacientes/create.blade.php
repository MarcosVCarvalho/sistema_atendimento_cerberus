@extends('layouts.default')

@section('title', 'Novo Paciente')

@section('content')

<div class="container">

```
{{-- Cabeçalho --}}
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="fw-bold text-dark mb-1">
            Novo Paciente
        </h1>

        <p class="text-muted mb-0">
            Cadastre um novo paciente no sistema.
        </p>
    </div>

    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
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
            Dados do paciente
        </h5>

    </div>

    <div class="card-body">

        <form action="{{ route('pacientes.store') }}" method="POST">

            @csrf

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
                    value="{{ old('nome') }}"
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

            {{-- CPF --}}
            <div class="mb-3">

                <label for="cpf" class="form-label fw-semibold">
                    CPF
                </label>

                <input
                    type="text"
                    name="cpf"
                    id="cpf"
                    class="form-control @error('cpf') is-invalid @enderror"
                    value="{{ old('cpf') }}"
                    placeholder="Ex: 123.456.789-00"
                    required
                >

                @error('cpf')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Telefone --}}
            <div class="mb-3">

                <label for="telefone" class="form-label fw-semibold">
                    Telefone
                </label>

                <input
                    type="text"
                    name="telefone"
                    id="telefone"
                    class="form-control @error('telefone') is-invalid @enderror"
                    value="{{ old('telefone') }}"
                    placeholder="Ex: (88) 9 8888-8888"
                    required
                >

                @error('telefone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- WhatsApp --}}
            <div class="mb-3">

                <label for="whatsapp" class="form-label fw-semibold">
                    WhatsApp
                </label>

                <input
                    type="text"
                    name="whatsapp"
                    id="whatsapp"
                    class="form-control @error('whatsapp') is-invalid @enderror"
                    value="{{ old('whatsapp') }}"
                    placeholder="Ex: (88) 9 8888-8888"
                >

                @error('whatsapp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Endereço --}}
            <div class="mb-4">

                <label for="endereco" class="form-label fw-semibold">
                    Endereço
                </label>

                <textarea
                    name="endereco"
                    id="endereco"
                    rows="3"
                    class="form-control @error('endereco') is-invalid @enderror"
                    placeholder="Ex: Rua das Flores, 123 - Centro"
                >{{ old('endereco') }}</textarea>

                @error('endereco')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- Botões --}}
            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('pacientes.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cadastrar paciente
                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

@endsection
