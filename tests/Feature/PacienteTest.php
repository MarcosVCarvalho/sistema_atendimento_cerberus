<?php

use App\Models\User;
use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuário autenticado consegue cadastrar paciente', function () {

    $usuario = User::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->post(route('pacientes.store'), [
            'nome' => 'João da Silva',
            'cpf' => '52998224725',
            'telefone' => '86999999999',
            'whatsapp' => '86999999999',
            'endereco' => 'Rua das Flores, 123',
        ]);

    $response->assertRedirect(route('pacientes.index'));

    $this->assertDatabaseHas('pacientes', [
        'nome' => 'João da Silva',
        'cpf' => '52998224725',
    ]);
});