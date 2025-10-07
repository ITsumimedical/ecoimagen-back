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
        Schema::create('estratificacion_framinghams', function (Blueprint $table) {
            $table->id();
            $table->text('tratamiento')->nullable();
            $table->integer('edad_puntaje')->nullable();
            $table->float('colesterol_total')->nullable();
            $table->integer('colesterol_puntaje')->nullable();
            $table->float('colesterol_hdl')->nullable();
            $table->integer('colesterol_puntajehdl')->nullable();
            $table->integer('fumador_puntaje')->nullable();
            $table->integer('arterial_puntaje')->nullable();
            $table->float('totales')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->integer('diabetes_puntaje')->nullable();
            $table->text('porcentaje')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estratificacion_framinghams');
    }
};
