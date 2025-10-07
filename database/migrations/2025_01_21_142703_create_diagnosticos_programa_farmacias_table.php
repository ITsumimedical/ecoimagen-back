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
        Schema::create('diagnosticos_programa_farmacias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->foreignId('programa_farmacia_id')->constrained('programas_farmacias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos_programa_farmacias');
    }
};
