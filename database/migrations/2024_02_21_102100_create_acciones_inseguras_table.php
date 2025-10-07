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
        Schema::create('acciones_inseguras', function (Blueprint $table) {
            $table->id();
            $table->text('nombre')->nullable();
            $table->text('condiciones_paciente')->nullable();
            $table->text('metodos')->nullable();
            $table->text('colaborador')->nullable();
            $table->text('equipo_trabajo')->nullable();
            $table->text('ambiente')->nullable();
            $table->text('recursos')->nullable();
            $table->text('contexto')->nullable();
            $table->foreignId('analisis_evento_id')->constrained('analisis_eventos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_inseguras');
    }
};
