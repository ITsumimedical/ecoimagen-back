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
        Schema::create('novedades_contratos_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_medicamentos_id')->constrained('contratos_medicamentos');
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades_contratos_medicamentos');
    }
};
