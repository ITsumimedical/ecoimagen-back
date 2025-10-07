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
        Schema::create('orden_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('num_orden')->nullable();
            $table->integer('numero_peticion')->nullable();
            $table->string('codigo_examen')->nullable();
            $table->string('nombre_examen')->nullable();
            $table->integer('cantidad')->nullable();
            $table->integer('estado_cargado')->nullable();
            $table->integer('estado_resultado')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_detalles');
    }
};
