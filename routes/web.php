<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\TipoAtendimentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditoriaController;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

/*
|--------------------------------------------------------------------------
| Rotas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    /*
    |--------------------------------------------------------------------------
    | Pacientes
    |--------------------------------------------------------------------------
    */

    Route::resource('pacientes', PacienteController::class);

    // Busca personalizada
    Route::get('/pacientes/buscar', [PacienteController::class, 'buscar'])
        ->name('pacientes.buscar');

    // Ficha do paciente
    Route::get('/pacientes/{paciente}/ficha', [PacienteController::class, 'ficha'])
        ->name('pacientes.ficha');


    /*
    |--------------------------------------------------------------------------
    | Atendimentos
    |--------------------------------------------------------------------------
    */

    // IMPORTANTE: rotas personalizadas vêm ANTES do resource.
    Route::get('/atendimentos/hoje', [AtendimentoController::class, 'hoje'])
        ->name('atendimentos.hoje');

    Route::resource('atendimentos', AtendimentoController::class);


    /*
    |--------------------------------------------------------------------------
    | Tipos de Atendimento
    |--------------------------------------------------------------------------
    */

    Route::resource('tipos-atendimento', TipoAtendimentoController::class);

    



    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Apenas administradores
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('usuarios', UserController::class)
        ->except('show');

    Route::get('/relatorios', [RelatorioController::class, 'index'])
    ->name('relatorios.index');

    Route::get('/relatorios/pdf', [RelatorioController::class, 'pdf'])
    ->name('relatorios.pdf');

    Route::get('/auditorias', [AuditoriaController::class, 'index'])
        ->name('auditorias.index');
    
});


/*
|--------------------------------------------------------------------------
| Breeze (Login, Logout, Registro...)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';