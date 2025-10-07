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
        Schema::create('radicacion_glosas', function (Blueprint $table) {
            $table->id();
            $table->text('respuesta_prestador')->nullable();
            $table->string('archivo')->nullable();
            $table->string('codigo')->nullable();
            $table->string('valor_aceptado')->nullable();
            $table->string('valor_no_aceptado')->nullable();
            $table->boolean('estado')->default(0);
            $table->foreignId('glosa_id')->nullable()->constrained('glosas');
            $table->foreignId('prestador_id')->nullable()->constrained('prestadores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radicacion_glosas');
    }
};
