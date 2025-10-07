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
        Schema::create('escala_abreviada_desarrollos', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->string('rango');
            $table->string('item');
            $table->string('valor_1');
            $table->string('valor_2');
            $table->string('valor_3');
            $table->string('valor_4');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escala_abreviada_desarrollos');
    }
};
