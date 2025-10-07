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
        Schema::create('dispensar_prestadors', function (Blueprint $table) {
            $table->id();
            $table->string('dispensar')->nullable();
            $table->string('pendiente')->nullable();
            $table->string('dispensado')->nullable();
            $table->foreignId('orden_articulo_id')->constrained('orden_articulos');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispensar_prestadors');
    }
};
