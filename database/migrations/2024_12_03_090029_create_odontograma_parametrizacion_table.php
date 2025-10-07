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
        Schema::create('odontograma_parametrizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('categoria');
            $table->string('color');
            $table->string('descripcion');
            $table->string('identificador');
            $table->string('caracter');
            $table->string('posicion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontograma_parametrizaciones');
    }
};
