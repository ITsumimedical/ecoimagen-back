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
        Schema::table('ordenes', function (Blueprint $table) {
            $table->string('nombre_esquema')->nullable();
            $table->string('ciclo')->nullable();
            $table->string('ciclo_total')->nullable();
            $table->string('dia')->nullable();
            $table->string('frecuencia_repeticion')->nullable();
            $table->string('biografia')->nullable();
            $table->string('fecha_agendamiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->string('nombre_esquema')->nullable();
            $table->string('aplicacion')->nullable();
            $table->string('ciclo')->nullable();
            $table->string('dia')->nullable();
            $table->string('frecuencia_repeticion')->nullable();
            $table->string('biografia')->nullable();
            $table->string('fecha_agendamiento')->nullable();
        });
    }
};
