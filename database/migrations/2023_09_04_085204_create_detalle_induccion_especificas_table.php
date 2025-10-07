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
        Schema::create('detalle_induccion_especificas', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion_actividad')->nullable();
            $table->string('usuario_ingreso_plataforma')->nullable();
            $table->string('contrasena_ingreso_plataforma')->nullable();
            $table->date('fecha_realizacion')->nullable();
            $table->string('realizado')->nullable();
            $table->foreignId('induccion_especifica_id')->constrained('induccion_especificas');
            $table->foreignId('tema_id')->constrained('tema_induccion_especificas');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_induccion_especificas');
    }
};
