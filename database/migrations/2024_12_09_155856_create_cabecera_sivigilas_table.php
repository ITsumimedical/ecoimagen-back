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
        Schema::create('cabecera_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cabecera');
            $table->string('sub_titulo')->nullable();
            $table->foreignId('evento_id')->constrained('evento_sivigilas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabecera_sivigilas');
    }
};
