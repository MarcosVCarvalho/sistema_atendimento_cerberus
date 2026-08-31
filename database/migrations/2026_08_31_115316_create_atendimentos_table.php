<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete();

            $table->foreignId('tipo_atendimento_id')
                ->constrained('tipos_atendimento')
                ->restrictOnDelete();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            $table->text('observacoes')->nullable();
            $table->text('encaminhamentos')->nullable();

            $table->dateTime('data_hora');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};