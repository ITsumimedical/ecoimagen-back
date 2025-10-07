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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->boolean('imprimir_resultados_laboratorios')->nullable();
            $table->boolean('imprimir_ayudas_diagnosticas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('imprimir_resultados_laboratorios');
            $table->dropColumn('imprimir_ayudas_diagnosticas');
        });
    }
};
