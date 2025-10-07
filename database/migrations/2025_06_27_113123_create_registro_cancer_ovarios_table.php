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
        Schema::create('registro_cancer_ovarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_biopsias_patologia_id')->constrained('registro_biopsias_patologias');
            $table->string('lateralidad_1');
            $table->string('lateralidad_2');
            $table->string('laboratorio_procesa');
            $table->string('nombre_patologo');
            $table->timestamp('fecha_ingreso_ihq');
            $table->timestamp('fecha_salida_ihq');
            $table->string('clasificacion_t');
            $table->string('clasificacion_n');
            $table->string('clasificacion_m');
            $table->text('estadio_figo');
            $table->text('descripcion_estadio_figo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_cancer_ovarios');
    }
};
