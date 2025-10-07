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
        Schema::create('caracterizacion_rutas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caracterizacion_id')->constrained('caracterizacion_afiliados');
            $table->foreignId('ruta_promocion_id')->constrained('ruta_promocion_caracterizacions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracterizacion_rutas');
    }
};
