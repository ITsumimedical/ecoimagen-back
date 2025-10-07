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
        Schema::create('antecedente_sexuales', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_antecedentes_sexuales');
            $table->string('tipo_orientacion_sexual')->nullable();
            $table->string('tipo_identidad_genero')->nullable();
            $table->string('resultado')->nullable();
            $table->integer('cuantos')->nullable();
            $table->integer('edad')->nullable();
            $table->foreignId('medico_registra')->constrained('users');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedente_sexuales');
    }
};
