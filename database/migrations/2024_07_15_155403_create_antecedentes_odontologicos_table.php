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
        Schema::create('antecedentes_odontologicos', function (Blueprint $table) {
            $table->id();
            $table->date('ultima_consulta_odontologo');
            $table->string('descripcion_ultima_consulta');
            $table->boolean('aplicacion_fluor_sellantes')->nullable();
            $table->string('descripcion_aplicacion_fl_sellante')->nullable();
            $table->boolean('exodoncias')->nullable();
            $table->string('descripcion_exodoncia')->nullable();
            $table->boolean('traumas')->nullable();
            $table->string('descripcion_trauma')->nullable();
            $table->boolean('aparatologia')->nullable();
            $table->string('descripcion_aparatologia')->nullable();
            $table->boolean('biopsias')->nullable();
            $table->string('descripcion_biopsia')->nullable();
            $table->boolean('cirugias_orales')->nullable();
            $table->string('descripcion_cirugia_oral')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes_odontologicos');
    }
};
