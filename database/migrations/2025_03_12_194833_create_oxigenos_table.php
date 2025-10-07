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
        Schema::create('oxigenos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha');
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('flujo');
            $table->string('flo2')->nullable();
            $table->string('total_litros');
            $table->string('total_horas');
            $table->string('modo_administracion');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('admision_urgencia_id')->constrained('admisiones_urgencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oxigenos');
    }
};
