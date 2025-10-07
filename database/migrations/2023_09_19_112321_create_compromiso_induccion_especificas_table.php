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
        Schema::create('compromiso_induccion_especificas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('induccion_especifica_id')->constrained('induccion_especificas');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->text('compromiso');
            $table->string('tiempo_seguimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compromiso_induccion_especificas');
    }
};
