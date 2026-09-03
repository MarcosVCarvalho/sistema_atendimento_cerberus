<?php

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('paciente é removido usando soft delete', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $this
        ->actingAs($usuario)
        ->delete(route('pacientes.destroy', $paciente));

    $this->assertSoftDeleted('pacientes', [
        'id' => $paciente->id,
    ]);
});

test('paciente removido não aparece na consulta normal', function () {

    $paciente = Paciente::factory()->create();

    $paciente->delete();

    expect(
        Paciente::find($paciente->id)
    )->toBeNull();
});

test('paciente removido continua armazenado no banco', function () {

    $paciente = Paciente::factory()->create();

    $paciente->delete();

    $pacienteExcluido = Paciente::withTrashed()
        ->find($paciente->id);

    expect($pacienteExcluido)->not->toBeNull();
});