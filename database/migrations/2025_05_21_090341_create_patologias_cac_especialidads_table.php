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
        Schema::create('patologias_cac_especialidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patologia_cac_id')->constrained('patologias_cacs');
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patologias_cac_especialidads');
    }
};
