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
        Schema::create('biopsia_cancer_mamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_biopsias_patologia_id')->constrained('registro_biopsias_patologias');
            $table->string('laboratorio_procesa')->nullable();
            $table->string('nombre_patologo')->nullable();
            $table->timestamp('fecha_ingreso_ihq')->nullable();
            $table->timestamp('fecha_salida_ihq')->nullable();
            $table->string('estrogenos')->nullable();
            $table->string('progestagenos')->nullable();
            $table->float('porcentaje_estrogenos')->nullable();
            $table->float('porcentaje_progestagenos')->nullable();
            $table->string('ki_67')->nullable();
            $table->string('her2')->nullable();
            $table->string('clasificacion_t')->nullable();
            $table->text('descripcion_t')->nullable();
            $table->string('clasificacion_n')->nullable();
            $table->text('descripcion_n')->nullable();
            $table->string('clasificacion_m')->nullable();
            $table->text('descripcion_m')->nullable();
            $table->text('subtipo_molecular')->nullable();
            $table->text('fish')->nullable();
            $table->text('brca')->nullable();
            $table->text('estadio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biopsia_cancer_mamas');
    }
};
