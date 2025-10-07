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
        Schema::create('sistemas_respiratorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('creado_por')->constrained('users');
            $table->string('escala_disnea_mrc');
            $table->string('indice_bode');
            $table->string('bodex');
            $table->string('escala_de_epworth');
            $table->string('escala_de_borg');
            $table->string('evaluacion_cat');
            $table->string('stop_bang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistemas_respiratorios');
    }
};
