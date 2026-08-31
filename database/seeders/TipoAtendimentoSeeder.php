<?php

namespace Database\Seeders;

use App\Models\TipoAtendimento;
use Illuminate\Database\Seeder;

class TipoAtendimentoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Odontologia',
            'Cardiologia',
            'Oftalmologia',
            'Dermatologia',
            'Clínico Geral',
            'Fisioterapia',
            'Nutrição',
        ];

        foreach ($tipos as $tipo) {
            TipoAtendimento::create([
                'nome' => $tipo,
                'ativo' => true,
            ]);
        }
    }
}