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
        Schema::create('neuropsicologias', function (Blueprint $table) {
            $table->id();
            $table->string('estado_animo_comportamiento');
            $table->string('actividades_basicas_instrumentales');
            $table->string('nivel_pre_morbido');
            $table->string('composicion_familiar');
            $table->string('evolucion_pruebas');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neuropsicologias');
    }
};
