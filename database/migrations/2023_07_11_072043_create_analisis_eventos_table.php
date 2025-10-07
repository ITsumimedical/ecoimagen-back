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
        Schema::create('analisis_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_adverso_id')->constrained('evento_adversos');
            $table->date('fecha_analisis')->nullable();
            $table->text('cronologia_suceso')->nullable();
            $table->text('clasificacion_analisis')->nullable();
            $table->text('metodologia_analisis')->nullable();
            $table->text('que_fallo')->nullable();
            $table->text('como_fallo')->nullable();
            $table->text('que_causo')->nullable();
            $table->text('plan_accion')->nullable();
            $table->text('accion_resarcimiento')->nullable();
            $table->text('descripcion_consecuencias')->nullable();
            $table->string('desenlace_evento')->nullable();
            $table->string('severidad_evento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_eventos');
    }
};
