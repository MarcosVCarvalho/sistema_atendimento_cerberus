<?php

namespace Database\Seeders;

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use App\Models\User;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@prefeitura.test',
        ]);

        $tipos = TipoAtendimento::all();

        $pacientes = Paciente::factory(120)->create();

        foreach ($pacientes as $paciente) {

            $quantidadeAtendimentos = rand(1, 4);

            for ($i = 0; $i < $quantidadeAtendimentos; $i++) {

                Atendimento::create([
                    'paciente_id' => $paciente->id,

                    'tipo_atendimento_id' => $tipos->random()->id,

                    'usuario_id' => $usuario->id,

                    'observacoes' => fake()->paragraph(),

                    'encaminhamentos' => fake()->sentence(),

                    'data_hora' => fake()->dateTimeBetween(
                        '-30 days',
                        'now'
                    ),
                ]);
            }
        }
    }
}