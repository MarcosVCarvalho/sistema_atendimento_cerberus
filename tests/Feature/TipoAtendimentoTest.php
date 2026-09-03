<?php

use App\Models\TipoAtendimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

uses(RefreshDatabase::class);

test('usuário autenticado consegue criar tipo de atendimento', function () {

    $usuario = User::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->post(route('tipos-atendimento.store'), [
            'nome' => 'Neurologia',
            'descricao' => 'Atendimento neurológico.',
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('tipos_atendimento', [
        'nome' => 'Neurologia',
    ]);
});

test('não permite cadastrar tipo de atendimento duplicado', function () {

    $usuario = User::factory()->create();

    TipoAtendimento::create([
        'nome' => 'Cardiologia',
    ]);

    $response = $this
        ->actingAs($usuario)
        ->post(route('tipos-atendimento.store'), [
            'nome' => 'Cardiologia',
            'descricao' => 'Outro tipo.',
        ]);

    $response->assertSessionHasErrors('nome');
});

test('tipo de atendimento pode ser removido com soft delete', function () {

    $usuario = User::factory()->create();

    $tipo = TipoAtendimento::create([
        'nome' => 'Neurologia',
    ]);

    $this
        ->actingAs($usuario)
        ->delete(route('tipos-atendimento.destroy', $tipo));

    $this->assertSoftDeleted('tipos_atendimento', [
        'id' => $tipo->id,
    ]);
});