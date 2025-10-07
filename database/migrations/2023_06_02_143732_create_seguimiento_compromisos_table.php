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
        Schema::create('seguimiento_compromisos', function (Blueprint $table) {
            $table->id();
            $table->string('tiempo');
            $table->string('seguimiento',400);
            $table->foreignId('calificacion_competencia_id')->constrained('calificacion_competencias');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('aprobado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_compromisos');
    }
};
