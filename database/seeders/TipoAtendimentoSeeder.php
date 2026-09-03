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
            'Psicologia',
            'Psiquiatria',
            'Pediatria',
            'Ginecologia',
            'Urologia',
            'Neurologia',
            'Ortopedia',
            'Endocrinologia',
            'Reumatologia',
            'Otorrinolaringologia',
            'Gastroenterologia',
            'Hematologia',
            'Oncologia',
            'Nefrologia',
            'Pneumologia',
            'Infectologia',
            'Alergologia',
            'Imunologia',
            'Radiologia',
            'Anestesiologia',
            'Cirurgia Geral',
            'Cirurgia Plástica',
            'Cirurgia Vascular',
            'Cirurgia Torácica',
            'Cirurgia Pediátrica',
        ];

        foreach ($tipos as $tipo) {
            TipoAtendimento::create([
                'nome' => $tipo,
            ]);
        }
    }
}