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
        Schema::create('periodontogramas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->string('diente')->nullable();
            $table->string('diente_tipo')->nullable();
            $table->string('oclusal')->nullable();
            $table->string('mesial')->nullable();
            $table->string('distal')->nullable();
            $table->string('vestibular')->nullable();
            $table->string('palatino')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodontogramas');
    }
};
