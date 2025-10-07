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
        Schema::create('licencia_empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contrato_empleados');
            $table->foreignId('tipo_licencia_id')->constrained('tipo_licencia_empleados');
            $table->foreignId('estado_id')->constrained('estados');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('observaciones');
            $table->text('motivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencia_empleados');
    }
};
