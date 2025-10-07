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
        Schema::create('municipio_tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarifa_id')->constrained('tarifas');
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipio_tarifas');
    }
};
