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
        Schema::create('acciones_mejora_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('responsable');
            $table->date('fecha_cumplimiento');
            $table->date('fecha_seguimiento')->nullable();
            $table->string('estado');
            $table->foreignId('analisis_evento_id')->constrained('analisis_eventos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acciones_mejora_eventos');
    }
};
