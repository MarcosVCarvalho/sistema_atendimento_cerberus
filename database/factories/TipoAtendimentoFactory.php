<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoAtendimento>
 */
class TipoAtendimentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->randomElement([
                'Odontologia',
                'Cardiologia',
                'Oftalmologia',
                'Dermatologia',
                'Clínico Geral',
                'Fisioterapia',
                'Nutrição',
            ]),
            'ativo' => true,
        ];
    }
}