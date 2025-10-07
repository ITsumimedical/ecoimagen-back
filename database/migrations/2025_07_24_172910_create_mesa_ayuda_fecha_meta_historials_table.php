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
        Schema::create('mesa_ayuda_fecha_meta_historials', function (Blueprint $table) {
            $table->id();
            $table->text('motivo');
             $table->foreignId('mesa_ayuda_id')->constrained('mesa_ayudas');
            $table->dateTime('fecha_anterior')->nullable();
            $table->dateTime('fecha_nueva');
            $table->foreignId('modificado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesa_ayuda_fecha_meta_historials');
    }
};
