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
        Schema::create('gestiones_telesaluds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('telesalud_id')->constrained('telesaluds');
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->foreignId('funcionario_gestiona_id')->constrained('users');
            $table->string('prioridad')->nullable();
            $table->string('pertinencia_solicitud')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestiones_telesaluds');
    }
};
