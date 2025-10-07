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
        Schema::create('detalle_programacion_mensual_ths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programacion_mensual_id')->constrained('programacion_mensual_ths');
            $table->foreignId('turno_id')->constrained('turno_ths');
            $table->foreignId('etiqueta_id')->constrained('etiqueta_ths');
            $table->foreignId('servicio_id')->constrained('servicio_ths');
            $table->integer('dia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_programacion_mensual_ths');
    }
};
