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
        Schema::table('categoria_historias', function (Blueprint $table) {
            $table->foreignId('tipo_categoria_historia_id')->constrained('tipo_categoria_historias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categoria_historias', function (Blueprint $table) {
            $table->foreignId('tipo_categoria_historia_id')->constrained('tipo_categoria_historias');
        });
    }
};
