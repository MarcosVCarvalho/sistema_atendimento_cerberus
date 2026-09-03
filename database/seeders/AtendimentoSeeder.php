<?php

namespace Database\Seeders;

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use App\Models\User;
use Illuminate\Database\Seeder;

class AtendimentoSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::pluck('id');

        $tipos = TipoAtendimento::pluck('id');

        $usuarios = User::pluck('id');

        if ($pacientes->isEmpty()) {
            $this->command->error('Nenhum paciente encontrado.');
            return;
        }

        if ($tipos->isEmpty()) {
            $this->command->error('Nenhum tipo de atendimento encontrado.');
            return;
        }

        if ($usuarios->isEmpty()) {
            $this->command->error('Nenhum usuário encontrado.');
            return;
        }

        for ($i = 0; $i < 300; $i++) {
            Atendimento::create([
                'paciente_id' => $pacientes->random(),
                'tipo_atendimento_id' => $tipos->random(),
                'usuario_id' => $usuarios->random(),

                'observacoes' => fake()->optional(0.8)->sentence(
                    fake()->numberBetween(8, 18)
                ),

                'encaminhamentos' => fake()->optional(0.5)->sentence(
                    fake()->numberBetween(5, 12)
                ),

                'data_hora' => fake()->dateTimeBetween(
                    '-6 months',
                    'now'
                ),
            ]);
        }

        $this->command->info('300 atendimentos criados com sucesso!');
    }
}