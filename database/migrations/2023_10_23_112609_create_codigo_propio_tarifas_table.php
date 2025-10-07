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
        Schema::create('codigo_propio_tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarifa_id')->constrained('tarifas');
            $table->foreignId('codigo_propio_id')->constrained('codigo_propios');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato_propio');
    }
};
