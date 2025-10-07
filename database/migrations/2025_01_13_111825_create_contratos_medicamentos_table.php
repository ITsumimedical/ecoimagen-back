<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contratos_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestador_id')->constrained('prestadores');
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->foreignId('ambito_id')->constrained('ambitos');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_vigencia');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos_medicamentos');
    }
};
