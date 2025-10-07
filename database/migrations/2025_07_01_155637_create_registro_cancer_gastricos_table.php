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
        Schema::create('registro_cancer_gastricos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_biopsias_patologia_id')->constrained('registro_biopsias_patologias');
            $table->string('laboratorio_procesa');
            $table->string('ubicacion_leson');
            $table->string('nombre_patologo')->nullable();
            $table->timestamp('fecha_ingreso_ihq');
            $table->timestamp('fecha_salida_ihq');
            $table->string('tipo_cancer_gastrico');
            $table->string('clasificacion_t');
            $table->string('clasificacion_n');
            $table->string('clasificacion_m');
            $table->text('estadio');
            $table->string('pd_l1')->nullable();
            $table->string('inestabilidad_microsatelital')->nullable();
            $table->string('her_2')->nullable();
            $table->string('gen_ntrk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_cancer_gastricos');
    }
};
