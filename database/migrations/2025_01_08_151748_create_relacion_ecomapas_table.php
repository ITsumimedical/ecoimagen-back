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
        Schema::create('relacion_ecomapas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_relacion')->nullable();
            $table->foreignId('figura_origen_id')->constrained('figura_ecomapas');
            $table->foreignId('figura_destino_id')->constrained('figura_ecomapas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relacion_ecomapas');
    }
};
