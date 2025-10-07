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
        Schema::create('adjunto_novedad_contratos', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->string('nombre');
            $table->foreignId('contrato_novedad_id')->constrained('novedad_contratos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjunto_novedad_contratos');
    }
};
