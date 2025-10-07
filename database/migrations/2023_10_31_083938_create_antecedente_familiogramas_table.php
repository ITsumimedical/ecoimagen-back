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
        Schema::create('antecedente_familiogramas', function (Blueprint $table) {
            $table->id();
            $table->string('vinculos')->nullable();
            $table->string('relacion')->nullable();
            $table->string('tipo_familia')->nullable();
            $table->integer('hijos_conforman')->nullable();
            $table->string('responsable_ingreso')->nullable();
            $table->string('problemas_de_salud')->nullable();
            $table->string('cual_salud')->nullable();
            $table->string('observacion_salud')->nullable();
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
        Schema::dropIfExists('antecedente_familiogramas');
    }
};
