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
        Schema::create('integrantes_junta_girs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teleapoyo_id')->constrained('teleapoyos');
            $table->foreignId('operador_id')->constrained('operadores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrantes_junta_girs');
    }
};
