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
        Schema::table('orden_procedimientos', function (Blueprint $table) {
            $table->date('fecha_solicitada')->nullable();
            $table->date('fecha_sugerida')->nullable();
            $table->date('fecha_cancelacion')->nullable();
            $table->string('cancelacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('responsable')->nullable();
            $table->string('motivo')->nullable();
            $table->string('causa')->nullable();
            $table->json('soportes')->nullable();
            $table->boolean('atendida')->nullable();
            $table->string('cirujano')->nullable();
            $table->string('especialidad')->nullable();
            $table->date('fecha_Preanestesia')->nullable();
            $table->date('fecha_cirugia')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->date('fecha_orden')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_procedimientos', function (Blueprint $table) {
            $table->date('fecha_solicitada')->nullable();
            $table->date('fecha_sugerida')->nullable();
            $table->date('fecha_cancelacion')->nullable();
            $table->string('cancelacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('responsable')->nullable();
            $table->string('motivo')->nullable();
            $table->string('causa')->nullable();
            $table->json('soportes')->nullable();
            $table->boolean('atendida')->nullable();
            $table->string('cirujano')->nullable();
            $table->string('especialidad')->nullable();
            $table->date('fecha_Preanestesia')->nullable();
            $table->date('fecha_cirugia')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->date('fecha_orden')->nullable();
        });
    }
};
