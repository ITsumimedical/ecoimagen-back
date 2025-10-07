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
        Schema::create('rips_transacciones', function (Blueprint $table) {
            $table->id();
            $table->string('numDocumentoIdObligado')->nullable();
            $table->string('numFactura')->nullable();
            $table->string('tipoNota')->nullable();
            $table->string('numNota')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->foreignId('prestador_id')->constrained('prestadores');
            $table->foreignId('estado_id')->constrained('estados');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rips_transacciones');
    }
};
