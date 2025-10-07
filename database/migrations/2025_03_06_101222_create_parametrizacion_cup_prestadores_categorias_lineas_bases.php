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
        Schema::create('parametrizacion_cup_prestadores_categorias_lineas_bases', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->foreignId('linea_base_id')->constrained('lineas_bases');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametrizacion_cup_prestadores_categorias_lineas_bases');
    }
};
