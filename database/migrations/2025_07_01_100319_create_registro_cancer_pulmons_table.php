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
        Schema::create('registro_cancer_pulmons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_biopsias_patologia_id')->constrained('registro_biopsias_patologias');
            $table->string('laboratorio_procesa');
            $table->timestamp('fecha_ingreso_ihq');
            $table->timestamp('fecha_salida_ihq');
            $table->string('tipo_cancer_pulmon');
            $table->string('subtipo_histologico')->nullable();
            $table->text('nota_subtipo_histologico')->nullable();
            $table->string('clasificacion_t');
            $table->string('clasificacion_n');
            $table->string('clasificacion_m');
            $table->string('estadio_inicial');
            $table->text('panel_molecular')->nullable();
            $table->text('egfr')->nullable();
            $table->text('alk')->nullable();
            $table->text('ros_1')->nullable();
            $table->text('pd_l1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_cancer_pulmons');
    }
};
