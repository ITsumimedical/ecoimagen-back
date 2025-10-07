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
        Schema::create('inventario_farmacias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bodega_id')->constrained('bodegas');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('realizado_por')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_farmacias');
    }
};
