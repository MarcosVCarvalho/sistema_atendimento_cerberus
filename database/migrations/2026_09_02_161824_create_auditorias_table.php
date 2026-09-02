<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
        $table->id();

        $table->foreignId('usuario_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->string('acao');

        $table->string('entidade');

        $table->unsignedBigInteger('entidade_id')->nullable();

        $table->text('descricao')->nullable();

        $table->timestamps();
});
    }
};
