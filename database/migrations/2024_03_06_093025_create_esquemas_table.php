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
        Schema::create('esquemas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_esquema')->nullable();
            $table->string('abreviatura_esquema')->nullable();
            $table->string('ciclos')->nullable();
            $table->string('frecuencia_repeat')->nullable();
            $table->string('biografia')->nullable();
            $table->boolean('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esquemas');
    }
};
