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
        Schema::create('cie10_transcripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transcripcione_id')->constrained('transcripciones');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cie10_transcripciones');
    }
};
