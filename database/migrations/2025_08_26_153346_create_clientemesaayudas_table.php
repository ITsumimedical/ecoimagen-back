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
        Schema::create('cliente_mesa_ayudas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('endpoint_pendiente');
            $table->string('endpoint_accion_comentario_solicitante');
            $table->string('endpoint_accion_reasignar');
            $table->string('endpoint_accion_solucionar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_mesa_ayudas');
    }
};
