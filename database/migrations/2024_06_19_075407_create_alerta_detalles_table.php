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
        Schema::create('alerta_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interaccion_id')->nullable()->constrained('cums');
            $table->foreignId('tipo_alerta_id')->constrained('tipo_alertas');
            $table->foreignId('mensaje_alerta_id')->constrained('mensajes_alertas');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('alerta_id')->constrained('alertas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerta_detalles');
    }
};
