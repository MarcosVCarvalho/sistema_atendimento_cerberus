<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $enderecos = [
            [
                'cidade' => 'Parnaíba',
                'bairro' => 'Centro',
            ],
            [
                'cidade' => 'Parnaíba',
                'bairro' => 'Nova Parnaíba',
            ],
            [
                'cidade' => 'Parnaíba',
                'bairro' => 'São José',
            ],
            [
                'cidade' => 'Parnaíba',
                'bairro' => 'Piauí',
            ],
            [
                'cidade' => 'Parnaíba',
                'bairro' => 'Frei Higino',
            ],
            [
                'cidade' => 'Luís Correia',
                'bairro' => 'Centro',
            ],
            [
                'cidade' => 'Luís Correia',
                'bairro' => 'Coqueiro',
            ],
            [
                'cidade' => 'Luís Correia',
                'bairro' => 'Nossa Senhora da Conceição',
            ],
            [
                'cidade' => 'Barroquinha',
                'bairro' => 'Centro',
            ],
            [
                'cidade' => 'Barroquinha',
                'bairro' => 'Boa Esperança',
            ],
            [
                'cidade' => 'Cocal',
                'bairro' => 'Centro',
            ],
            [
                'cidade' => 'Cocal',
                'bairro' => 'São Francisco',
            ],
        ];

        for ($i = 1; $i <= 120; $i++) {

            $endereco = fake()->randomElement($enderecos);

            Paciente::create([
                'nome' => fake()->name(),
                'cpf' => $this->cpfFake($i),
                'telefone' => '8699' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'whatsapp' => '8698' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'rua' => fake()->streetName(),
                'bairro' => $endereco['bairro'],
                'cidade' => $endereco['cidade'],
            ]);
        }

        $this->command->info('120 pacientes criados com sucesso!');
    }

    private function cpfFake(int $numero): string
    {
        return str_pad((string) $numero, 11, '0', STR_PAD_LEFT);
    }
}