<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('usuário comum não pode acessar gerenciamento de usuários', function () {

    $usuario = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this
        ->actingAs($usuario)
        ->get(route('usuarios.index'));

    $response->assertForbidden();
});

test('administrador pode acessar gerenciamento de usuários', function () {

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this
        ->actingAs($admin)
        ->get(route('usuarios.index'));

    $response->assertSuccessful();
});