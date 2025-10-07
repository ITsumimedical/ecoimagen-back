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
        Schema::create('adherencia_farmacoterapeutica', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->text('criterio_quimico')->nullable();
            $table->text('dejado_medicamento')->nullable();
            $table->text('dias_notomomedicamento')->nullable();
            $table->text('finsemana_notomomedicamento')->nullable();
            $table->text('finsemana_olvidomedicamento')->nullable();
            $table->text('hora_indicada')->nullable();
            $table->text('porcentaje')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adherencia_farmacoterapeutica');
    }
};
