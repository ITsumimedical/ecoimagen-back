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
        Schema::create('registro_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('evento_sivigilas');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->boolean('estado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_sivigilas');
    }
};
