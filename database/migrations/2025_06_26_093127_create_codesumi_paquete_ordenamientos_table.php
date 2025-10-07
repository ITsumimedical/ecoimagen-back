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
        Schema::create('codesumi_paquete_ordenamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paquete_ordenamiento_id')->constrained('paquete_ordenamientos');
            $table->foreignId('codesumi_id')->constrained('codesumis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codesumi_paquete_ordenamientos');
    }
};
