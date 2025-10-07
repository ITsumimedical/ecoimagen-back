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
        Schema::create('relaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_relacion')->nullable();
            $table->foreignId('figura_origen_id')->constrained('figuras');
            $table->foreignId('figura_destino_id')->constrained('figuras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relaciones');
    }
};
