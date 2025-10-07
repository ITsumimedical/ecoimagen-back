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
        Schema::create('figura_humanas', function (Blueprint $table) {
            $table->id();
            $table->integer('general')->nullable();
            $table->integer('tronco')->nullable();
            $table->integer('brazos_piernas')->nullable();
            $table->integer('cuello')->nullable();
            $table->integer('cara')->nullable();
            $table->integer('cabello')->nullable();
            $table->integer('ropas')->nullable();
            $table->integer('dedos')->nullable();
            $table->integer('articulaciones')->nullable();
            $table->integer('proporciones')->nullable();
            $table->integer('coordinacion_motora')->nullable();
            $table->integer('orejas')->nullable();
            $table->integer('ojos')->nullable();
            $table->integer('menton')->nullable();
            $table->integer('perfil')->nullable();
            $table->string('interpretacion_resultados')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figura_humanas');
    }
};
