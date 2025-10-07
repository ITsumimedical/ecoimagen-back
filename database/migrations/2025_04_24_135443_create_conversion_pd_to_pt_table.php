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
        Schema::create('conversion_pd_to_pt', function (Blueprint $table) {
            $table->id();
            $table->integer('puntuacion_directa')->nullable();
            $table->integer('rango')->nullable();
            $table->integer('puntuacion_total')->nullable();
            $table->foreignId('tipo_escala_abreviada_id')->constrained('tipo_escala_abreviada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversion_pd_to_pt');
    }
};
