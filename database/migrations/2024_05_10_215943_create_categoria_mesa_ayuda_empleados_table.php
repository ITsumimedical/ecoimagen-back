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
        Schema::create('categoria_mesa_ayuda_empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_mesa_ayuda_id')->constrained('categoria_mesa_ayudas');
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->boolean('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_mesa_ayuda_empleados');
    }
};
