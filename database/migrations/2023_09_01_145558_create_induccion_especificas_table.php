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
        Schema::create('induccion_especificas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->date('fecha_inicio_induccion');
            $table->date('fecha_finalizacion_induccion')->nullable();
            $table->boolean('cumplio_totalidad')->nullable()->default(false);
            $table->string('firma_facilitador')->nullable();
            $table->string('firma_empleado')->nullable();
            $table->boolean('activo')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('induccion_especificas');
    }
};
