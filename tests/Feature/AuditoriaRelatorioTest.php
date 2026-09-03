<?php

use App\Models\Auditoria;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('geração de relatório registra auditoria', function () {

    $usuario = User::factory()->create();

    $this
        ->actingAs($usuario)
        ->get(route('relatorios.pdf', [
            'data_inicio' => '2026-08-01',
            'data_fim' => '2026-08-31',
        ]));

    $this->assertDatabaseHas('auditorias', [
        'usuario_id' => $usuario->id,
        'acao' => 'relatório',
        'entidade' => 'Relatório',
    ]);
});