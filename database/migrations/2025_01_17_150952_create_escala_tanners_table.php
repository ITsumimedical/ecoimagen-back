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
        Schema::create('escala_tanners', function (Blueprint $table) {
            $table->id();
            $table->string('mamario_mujeres');
            $table->string('pubiano_mujeres');
            $table->string('genital_hombres');
            $table->string('pubiano_hombres');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escala_tanners');
    }
};
