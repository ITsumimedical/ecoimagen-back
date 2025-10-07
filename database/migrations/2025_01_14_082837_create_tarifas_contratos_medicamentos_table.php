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
        Schema::create('tarifas_contratos_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_medicamentos_id')->constrained('contratos_medicamentos');
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('manual_tarifario_id')->constrained('manual_tarifarios');
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
        Schema::dropIfExists('tarifas_contratos_medicamentos');
    }
};
