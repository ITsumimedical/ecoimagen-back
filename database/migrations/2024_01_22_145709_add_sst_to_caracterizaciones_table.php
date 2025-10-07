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
        Schema::table('caracterizaciones', function (Blueprint $table) {
            $table->string('rh')->nullable();
            $table->string('numero_hijos')->nullable();
            $table->string('tipo_contratacion')->nullable();
            $table->string('antiguedad_en_la_empresa')->nullable();
            $table->string('antiguedad_cargo_actual')->nullable();
            $table->string('numero_cursos_a_cargo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caracterizaciones', function (Blueprint $table) {
            $table->string('rh')->nullable();
            $table->string('numero_hijos')->nullable();
            $table->string('tipo_contratacion')->nullable();
            $table->string('antiguedad_en_la_empresa')->nullable();
            $table->string('antiguedad_cargo_actual')->nullable();
            $table->string('numero_cursos_a_cargo')->nullable();
        });
    }
};
