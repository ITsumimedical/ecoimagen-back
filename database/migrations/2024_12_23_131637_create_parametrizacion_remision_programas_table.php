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
        Schema::create('parametrizacion_remision_programas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('edad_inicial');
            $table->integer('edad_final');
            $table->string('sexo');
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametrizacion_remision_programas');
    }
};
