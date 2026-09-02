<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auditorias', function (Blueprint $table) {
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('acao');

            $table->string('entidade');

            $table->unsignedBigInteger('entidade_id')
                ->nullable();

            $table->text('descricao')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('auditorias', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn([
                'usuario_id',
                'acao',
                'entidade',
                'entidade_id',
                'descricao',
            ]);
        });
    }
};