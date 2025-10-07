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
        Schema::create('auditoria_alertas', function (Blueprint $table) {
            $table->id();
            $table->string('acepto');
            $table->foreignId('alerta_detalle_id')->nullable()->constrained('alerta_detalles');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('estado_alerta_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_alertas');
    }
};
