<?php

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuário autenticado consegue criar atendimento', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $tipo = TipoAtendimento::create([
        'nome' => 'Cardiologia',
    ]);

    $response = $this
        ->actingAs($usuario)
        ->post(route('atendimentos.store'), [
            'paciente_id' => $paciente->id,
            'tipo_atendimento_id' => $tipo->id,
            'observacoes' => 'Paciente apresentou melhora.',
            'encaminhamentos' => 'Retorno em 30 dias.',
            'data_hora' => now()->format('Y-m-d H:i:s'),
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('atendimentos', [
        'paciente_id' => $paciente->id,
        'tipo_atendimento_id' => $tipo->id,
        'usuario_id' => $usuario->id,
    ]);
});