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
        Schema::table('datos_indicador_fomag_oncologicos', function (Blueprint $table) {
            $table->string('fecha_fin_tto_neoadyuvancia')->nullable();
            $table->string('fecha_realizacion_cirugia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_indicador_fomag_oncologicos', function (Blueprint $table) {
            $table->dropColumn('fecha_fin_tto_neoadyuvancia');
            $table->dropColumn('fecha_realizacion_cirugia');
         });
    }
};
