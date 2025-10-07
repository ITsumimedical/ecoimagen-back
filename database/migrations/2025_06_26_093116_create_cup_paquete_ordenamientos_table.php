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
        Schema::create('cup_paquete_ordenamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paquete_ordenamiento_id')->constrained('paquete_ordenamientos');
            $table->foreignId('cup_id')->constrained('cups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cup_paquete_ordenamientos');
    }
};
