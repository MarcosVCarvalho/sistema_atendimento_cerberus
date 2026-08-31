<?php

use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TipoAtendimentoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return inertia('Home');
})->name('home');


/*
|--------------------------------------------------------------------------
| Atendimentos
|--------------------------------------------------------------------------
*/

// Atendimentos de hoje
Route::get(
    '/atendimentos/hoje',
    [AtendimentoController::class, 'hoje']
)->name('atendimentos.hoje');

// Lista de atendimentos
Route::get(
    '/atendimentos',
    [AtendimentoController::class, 'index']
)->name('atendimentos.index');

// Formulário de novo atendimento
Route::get(
    '/atendimentos/create',
    [AtendimentoController::class, 'create']
)->name('atendimentos.create');

// Salvar atendimento
Route::post(
    '/atendimentos',
    [AtendimentoController::class, 'store']
)->name('atendimentos.store');

// Visualizar atendimento
Route::get(
    '/atendimentos/{atendimento}',
    [AtendimentoController::class, 'show']
)->name('atendimentos.show');

// Formulário de edição
Route::get(
    '/atendimentos/{atendimento}/edit',
    [AtendimentoController::class, 'edit']
)->name('atendimentos.edit');

// Atualizar atendimento
Route::put(
    '/atendimentos/{atendimento}',
    [AtendimentoController::class, 'update']
)->name('atendimentos.update');

// Excluir atendimento
Route::delete(
    '/atendimentos/{atendimento}',
    [AtendimentoController::class, 'destroy']
)->name('atendimentos.destroy');


/*
|--------------------------------------------------------------------------
| Pacientes
|--------------------------------------------------------------------------
*/

// Lista e pesquisa
Route::get(
    '/pacientes',
    [PacienteController::class, 'index']
)->name('pacientes.index');

// Formulário de cadastro
Route::get(
    '/pacientes/create',
    [PacienteController::class, 'create']
)->name('pacientes.create');

// Salvar paciente
Route::post(
    '/pacientes',
    [PacienteController::class, 'store']
)->name('pacientes.store');

// Busca rápida
Route::get(
    '/pacientes/buscar',
    [PacienteController::class, 'buscar']
)->name('pacientes.buscar');

// Ficha do paciente
Route::get(
    '/pacientes/{paciente}/ficha',
    [PacienteController::class, 'ficha']
)->name('pacientes.ficha');

// Visualizar paciente
Route::get(
    '/pacientes/{paciente}',
    [PacienteController::class, 'show']
)->name('pacientes.show');

// Formulário de edição
Route::get(
    '/pacientes/{paciente}/edit',
    [PacienteController::class, 'edit']
)->name('pacientes.edit');

// Atualizar paciente
Route::put(
    '/pacientes/{paciente}',
    [PacienteController::class, 'update']
)->name('pacientes.update');

// Excluir paciente
Route::delete(
    '/pacientes/{paciente}',
    [PacienteController::class, 'destroy']
)->name('pacientes.destroy');


/*
|--------------------------------------------------------------------------
| Tipos de atendimento
|--------------------------------------------------------------------------
*/

// Lista
Route::get(
    '/tipos-atendimento',
    [TipoAtendimentoController::class, 'index']
)->name('tipos-atendimento.index');

// Formulário de cadastro
Route::get(
    '/tipos-atendimento/create',
    [TipoAtendimentoController::class, 'create']
)->name('tipos-atendimento.create');

// Salvar
Route::post(
    '/tipos-atendimento',
    [TipoAtendimentoController::class, 'store']
)->name('tipos-atendimento.store');

// Visualizar
Route::get(
    '/tipos-atendimento/{tipoAtendimento}',
    [TipoAtendimentoController::class, 'show']
)->name('tipos-atendimento.show');

// Formulário de edição
Route::get(
    '/tipos-atendimento/{tipoAtendimento}/edit',
    [TipoAtendimentoController::class, 'edit']
)->name('tipos-atendimento.edit');

// Atualizar
Route::put(
    '/tipos-atendimento/{tipoAtendimento}',
    [TipoAtendimentoController::class, 'update']
)->name('tipos-atendimento.update');

// Excluir
Route::delete(
    '/tipos-atendimento/{tipoAtendimento}',
    [TipoAtendimentoController::class, 'destroy']
)->name('tipos-atendimento.destroy');