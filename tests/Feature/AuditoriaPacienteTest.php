<?php

use App\Models\Auditoria;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('criação de paciente gera auditoria', function () {

    $usuario = User::factory()->create();

    $this
        ->actingAs($usuario)
        ->post(route('pacientes.store'), [
            'nome' => 'João da Silva',
            'cpf' => '52998224725',
            'telefone' => '86999999999',
            'whatsapp' => '86999999999',
            'endereco' => 'Rua das Flores',
        ]);

    $this->assertDatabaseHas('auditorias', [
        'usuario_id' => $usuario->id,
        'acao' => 'criado',
        'entidade' => 'Paciente',
    ]);
});

test('atualização de paciente gera auditoria', function () {

    $usuario = User::factory()->create();

    $this->actingAs($usuario);

    $paciente = Paciente::factory()->create([
        'nome' => 'Nome Original',
    ]);

    $response = $this->put(
        route('pacientes.update', $paciente),
        [
            'nome' => 'Nome Atualizado',
            'cpf' => $paciente->cpf,
            'telefone' => $paciente->telefone,
            'whatsapp' => $paciente->whatsapp,
            'endereco' => $paciente->endereco,
        ]
    );

    $response->assertRedirect();

    $this->assertDatabaseHas('pacientes', [
        'id' => $paciente->id,
        'nome' => 'Nome Atualizado',
    ]);

    $this->assertDatabaseHas('auditorias', [
        'usuario_id' => $usuario->id,
        'acao' => 'atualizado',
        'entidade' => 'Paciente',
        'entidade_id' => $paciente->id,
    ]);
});

test('exclusão de paciente gera auditoria', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $this
        ->actingAs($usuario)
        ->delete(route('pacientes.destroy', $paciente));

    $this->assertDatabaseHas('auditorias', [
        'usuario_id' => $usuario->id,
        'acao' => 'excluído',
        'entidade' => 'Paciente',
        'entidade_id' => $paciente->id,
    ]);
});