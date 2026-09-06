<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.test',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Dados do sistema
        $this->call([
            TipoAtendimentoSeeder::class,
            PacienteSeeder::class,
            AtendimentoSeeder::class,
        ]);
    }
}