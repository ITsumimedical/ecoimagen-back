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
        Schema::create('minutas', function (Blueprint $table) {
            $table->id();
            $table->boolean('tragos');
            $table->string('hora_tragos')->nullable();
            $table->string('desayuno');
            $table->string('media_manana');
            $table->string('almuerzo');
            $table->string('algo')->nullable();
            $table->string('comida');
            $table->string('merienda');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutas');
    }
};
