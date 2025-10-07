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
        Schema::create('paquete_tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarifa_id')->constrained('tarifas');
            $table->foreignId('paquete_servicio_id')->constrained('paquete_servicios');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_tarifas');
    }
};
