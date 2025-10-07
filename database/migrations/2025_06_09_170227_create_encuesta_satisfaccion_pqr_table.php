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
        Schema::create('encuesta_satisfaccion_pqr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulario_pqr_id')->constrained('formulariopqrsfs');
            $table->string('solucion_final');
            $table->string('comprension_clara');
            $table->string('respuesta_coherente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encuesta_satisfaccion_pqr');
    }
};
