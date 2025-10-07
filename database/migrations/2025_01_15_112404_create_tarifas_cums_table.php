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
        Schema::create('tarifas_cums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarifa_id')->constrained('tarifas_contratos_medicamentos');
            $table->string('cum_validacion');
            $table->decimal('precio', 15, 2);
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas_cums');
    }
};
