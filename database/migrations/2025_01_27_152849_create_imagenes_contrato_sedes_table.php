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
        Schema::create('imagenes_contrato_sedes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('url_imagen');
            $table->foreignId('rep_id')->constrained('reps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes_contrato_sedes');
    }
};
