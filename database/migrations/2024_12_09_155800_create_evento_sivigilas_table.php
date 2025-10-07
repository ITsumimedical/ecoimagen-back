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
        Schema::create('evento_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_evento');
            $table->integer('rango_edad_inicio');
            $table->integer('rango_edad_final');
            $table->boolean('gestante')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_sivigilas');
    }
};
