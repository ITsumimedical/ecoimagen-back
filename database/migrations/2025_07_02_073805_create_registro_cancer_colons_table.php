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
        Schema::create('registro_cancer_colons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_biopsias_patologia_id')->constrained('registro_biopsias_patologias');
            $table->string('ubicacion_leson')->nullable();
            $table->string('laboratorio_procesa')->nullable();
            $table->string('nombre_patologo')->nullable();
            $table->timestamp('fecha_ingreso_ihq')->nullable();
            $table->timestamp('fecha_salida_ihq')->nullable();
            $table->string('tipo_cancer_colon')->nullable();
            $table->string('subtipo_adenocarcinoma')->nullable();
            $table->string('clasificacion_t')->nullable();
            $table->string('clasificacion_n')->nullable();
            $table->string('clasificacion_m')->nullable();
            $table->string('estadio')->nullable();
            $table->string('cambio_estadio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_cancer_colons');
    }
};
