<?php

use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pacientes.index');
});


Route::resource('pacientes', PacienteController::class);