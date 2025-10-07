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
        Schema::create('valoracion_antropometricas', function (Blueprint $table) {
            $table->id();
            $table->string('peso_anterior')->nullable();
            $table->string('fecha_registro_peso_anterior')->nullable();
            $table->string('peso_actual');
            $table->string('altura_actual');
            $table->string('imc');
            $table->string('clasificacion');
            $table->string('perimetro_braquial')->nullable();
            $table->string('pliegue_grasa_tricipital')->nullable();
            $table->string('pliegue_grasa_subescapular')->nullable();
            $table->string('peso_talla')->nullable();
            $table->string('longitud_talla')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoracion_antropometricas');
    }
};
