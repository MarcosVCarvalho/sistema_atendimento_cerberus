<?php

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuário autenticado pode visualizar um paciente', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->get(route('pacientes.show', $paciente));

    $response->assertSuccessful();
});

test('usuário autenticado pode editar um paciente', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->get(route('pacientes.edit', $paciente));

    $response->assertSuccessful();
});

test('usuário autenticado pode excluir um paciente', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->delete(route('pacientes.destroy', $paciente));

    $response->assertRedirect();

    $this->assertSoftDeleted('pacientes', [
        'id' => $paciente->id,
    ]);
});