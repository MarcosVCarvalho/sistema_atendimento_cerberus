<?php

use App\Http\Controllers\AlunoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('alunos.index');
});


Route::resource('alunos', AlunoController::class);