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
        Schema::create('telesaluds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_estrategia_id')->constrained('tipo_estrategia_telesaluds');
            $table->foreignId('tipo_solicitud_id')->constrained('tipo_solicitudes');
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->text('motivo');
            $table->text('resumen_hc');
            $table->foreignId('cup_id')->constrained('cups');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('funcionario_crea_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telesaluds');
    }
};
