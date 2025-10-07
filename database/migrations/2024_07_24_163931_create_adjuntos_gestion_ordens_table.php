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
        Schema::create('adjuntos_gestion_ordens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gestion_orden_id')->constrained('gestion_orden_prestador');
            $table->string('ruta');
            $table->string('nombre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjuntos_gestion_ordens');
    }
};
