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
        Schema::create('tipo_solicitud_empleados', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo')->default(1);
            $table->foreignId('tipo_solicitud_red_vital_id')->nullable()->constrained('tipo_solicitud_red_vitals');
            $table->foreignId('empleado_id')->nullable()->constrained('empleados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_solicitud_empleados');
    }
};
