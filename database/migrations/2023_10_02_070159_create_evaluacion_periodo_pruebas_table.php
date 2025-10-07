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
        Schema::create('evaluacion_periodo_pruebas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_evaluacion');
            $table->foreignId('empleado_evaluado_id')->constrained('empleados');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->text('descripcion_experiencia_empresa');
            $table->text('descripcion_experiencia_induccion');
            $table->boolean('aprueba_periodo_prueba')->default(false);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_periodo_pruebas');
    }
};
