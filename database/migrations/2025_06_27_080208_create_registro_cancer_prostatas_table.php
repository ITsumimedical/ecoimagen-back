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
        Schema::create('registro_cancer_prostatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_biopsias_patologia_id')->constrained('registro_biopsias_patologias');
            $table->integer('psa');
            $table->string('lobulo');
            $table->string('lobulo_derecho')->nullable();
            $table->string('lobulo_izquierdo')->nullable();
            $table->timestamp('fecha_ingreso_ihq');
            $table->timestamp('fecha_salida_ihq');
            $table->string('grado');
            $table->string('riesgo');
            $table->string('clasificacion_t');
            $table->text('descripcion_clasificacion_t')->nullable();
            $table->string('clasificacion_m')->nullable();
            $table->text('descripcion_clasificacion_m')->nullable();
            $table->string('clasificacion_n')->nullable();
             $table->text('descripcion_clasificacion_n')->nullable();
            $table->text('estadio')->nullable();
            $table->text('extension')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_cancer_prostatas');
    }
};
