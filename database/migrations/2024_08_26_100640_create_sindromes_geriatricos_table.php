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
        Schema::create('sindromes_geriatricos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->string('deterioro_cognoscitivo')->nullable();
            $table->string('inmovilidad')->nullable();
            $table->string('inestabilidad_caidas')->nullable();
            $table->string('fragilidad')->nullable();
            $table->string('incontinencia_esfinteres')->nullable();
            $table->string('depresion')->nullable();
            $table->string('iatrogenia_medicamentosa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sindromes_geriatricos');
    }
};
