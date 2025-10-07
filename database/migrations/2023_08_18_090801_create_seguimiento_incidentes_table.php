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
        Schema::create('seguimiento_incidentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incidente_id')->constrained('incidentes');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->text('seguimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_incidentes');
    }
};
