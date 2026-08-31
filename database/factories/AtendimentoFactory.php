<?php

namespace Database\Factories;

use App\Models\Atendimento;
use App\Models\Paciente;
use App\Models\TipoAtendimento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Atendimento>
 */
class AtendimentoFactory extends Factory
{
    protected $model = Atendimento::class;

    public function definition(): array
    {
        return [
            'paciente_id' => Paciente::factory(),
            'tipo_atendimento_id' => TipoAtendimento::factory(),
            'usuario_id' => User::factory(),
            'observacoes' => fake()->optional()->paragraph(),
            'encaminhamentos' => fake()->optional()->sentence(),
            'data_hora' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }
}