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
        Schema::create('antecedentes_patologias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->string('patologia_cancer_actual')->nullable();
            $table->string('fdx_cancer_actual')->nullable();
            $table->string('flaboratorio_patologia')->nullable();
            $table->string('tumor_segunda_biopsia')->nullable();
            $table->string('localizacion_cancer')->nullable();
            $table->string('dukes')->nullable();
            $table->string('gleason')->nullable();
            $table->string('Her2')->nullable();
            $table->string('estadificacion_clinica')->nullable();
            $table->string('estadificacion_inicial')->nullable();
            $table->string('fecha_estadificacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes_patologias');
    }
};
