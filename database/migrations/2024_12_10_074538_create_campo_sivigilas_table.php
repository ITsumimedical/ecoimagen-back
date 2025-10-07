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
        Schema::create('campo_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_campo');
            $table->string('tipo_campo')->nullable();
            $table->foreignId('cabecera_id')->constrained('cabecera_sivigilas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campo_sivigilas');
    }
};
