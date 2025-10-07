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
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->foreignId('usuario_reporta_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');
            $table->date('fecha_incidente');
            $table->string('periodicidad_seguimiento');
            $table->string('resultado')->nullable();
            $table->string('gravedad');
            $table->text('descripcion');
            $table->string('comentarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidentes');
    }
};
