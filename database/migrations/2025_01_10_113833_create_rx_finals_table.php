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
        Schema::create('rx_finals', function (Blueprint $table) {
            $table->id();
            $table->string('esfera_ojo_derecho')->nullable();
            $table->string('esfera_ojo_izquierdo')->nullable();
            $table->string('cilindro_ojo_derecho')->nullable();
            $table->string('cilindro_ojo_izquierdo')->nullable();
            $table->string('eje_ojo_derecho')->nullable();
            $table->string('eje_ojo_izquierdo')->nullable();
            $table->string('add_ojo_derecho')->nullable();
            $table->string('add_ojo_izquierdo')->nullable();
            $table->string('prima_base_ojo_derecho')->nullable();
            $table->string('prima_base_ojo_izquierdo')->nullable();
            $table->string('grados_ojo_derecho')->nullable();
            $table->string('grados_ojo_izquierdo')->nullable();
            $table->string('av_lejos_ojo_derecho')->nullable();
            $table->string('av_lejos_ojo_izquierdo')->nullable();
            $table->string('av_cerca_ojo_derecho')->nullable();
            $table->string('av_cerca_ojo_izquierdo')->nullable();
            $table->string('tipo_lentes')->nullable();
            $table->string('detalle')->nullable();
            $table->string('altura')->nullable();
            $table->string('color_ttos')->nullable();
            $table->string('dp')->nullable();
            $table->string('uso')->nullable();
            $table->string('control')->nullable();
            $table->string('duracion_vigencia')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rx_finals');
    }
};
