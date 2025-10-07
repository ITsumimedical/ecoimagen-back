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
        Schema::create('componentes_tipo_historia_clinicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_historia_id')->constrained('tipo_historias');
            $table->foreignId('componente_historia_id')->constrained('componentes_historia_clinicas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('componentes_tipo_historia_clinicas');
    }
};
