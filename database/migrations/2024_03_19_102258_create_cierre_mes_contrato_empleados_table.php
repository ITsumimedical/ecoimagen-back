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
        Schema::create('cierre_mes_contrato_empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contrato_empleados');
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->boolean('activo');
            $table->date('fecha_cierre_mes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cierre_mes_contrato_empleados');
    }
};
