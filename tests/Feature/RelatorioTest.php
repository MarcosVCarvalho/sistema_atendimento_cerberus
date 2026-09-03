<?php

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuário autenticado consegue acessar relatório', function () {

    $usuario = User::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->get(route('relatorios.index'));

    $response->assertSuccessful();
});

test('relatório considera período informado', function () {

    $usuario = User::factory()->create();

    $paciente = Paciente::factory()->create();

    $tipo = TipoAtendimento::create([
        'nome' => 'Cardiologia',
    ]);

    Atendimento::create([
        'paciente_id' => $paciente->id,
        'tipo_atendimento_id' => $tipo->id,
        'usuario_id' => $usuario->id,
        'observacoes' => 'Atendimento dentro do período.',
        'data_hora' => '2026-08-15 10:00:00',
    ]);

    Atendimento::create([
        'paciente_id' => $paciente->id,
        'tipo_atendimento_id' => $tipo->id,
        'usuario_id' => $usuario->id,
        'observacoes' => 'Atendimento fora do período.',
        'data_hora' => '2026-01-15 10:00:00',
    ]);

    $response = $this
        ->actingAs($usuario)
        ->get(route('relatorios.index', [
            'data_inicio' => '2026-08-01',
            'data_fim' => '2026-08-31',
        ]));

    $response->assertSuccessful();

    $response->assertInertia(fn ($page) =>
        $page
            ->where('resumo.total', 1)
    );
});