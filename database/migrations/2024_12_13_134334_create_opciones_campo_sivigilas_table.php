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
        Schema::create('opciones_campo_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_opcion');
            $table->foreignId('campo_id')->constrained('campo_sivigilas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_campo_sivigilas');
    }
};
