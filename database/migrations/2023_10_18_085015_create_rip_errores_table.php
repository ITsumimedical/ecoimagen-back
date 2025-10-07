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
        Schema::create('rip_errores', function (Blueprint $table) {
            $table->id();
            $table->string('archivo');
            $table->string('mensaje');
            $table->json('lineas');
            $table->foreignId('paquete_rip_id')->constrained('paquete_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rip_errores');
    }
};
