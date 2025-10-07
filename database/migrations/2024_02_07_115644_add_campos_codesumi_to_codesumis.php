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
        Schema::table('codesumis', function (Blueprint $table) {
            $table->string('frecuencia')->nullable();
            $table->string('cantidad_maxima_orden')->nullable();
            $table->string('concentracion_1')->nullable();
            $table->string('concentracion_2')->nullable();
            $table->string('concentracion_3')->nullable();
            $table->string('ambito')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('unidad_concentracion')->nullable();
            $table->string('cantiad_maxima_orden_dia')->nullable();
            $table->string('unidad_aux')->nullable();
            $table->foreignId('grupo_terapeutico_id')->nullable()->constrained('grupos_terapeuticos');
            $table->foreignId('subgrupos_terapeuticos')->nullable()->constrained('subgrupos_terapeuticos');
            $table->foreignId('forma_farmaceutica_id')->nullable()->constrained('formas_farmaceuticas');
            $table->foreignId('linea_base_id')->nullable()->constrained('lineas_bases');
            $table->foreignId('grupo_id')->nullable()->constrained('grupos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codesumis', function (Blueprint $table) {
            //
        });
    }
};
