<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('afiliado_integrante_familias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained()->onDelete('cascade');
            $table->foreignId('integrante_id')->constrained('integrantes_familia_caracterizacion_ecis')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['afiliado_id', 'integrante_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afiliado_integrante_familias');
    }
};
