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
        Schema::create('antecedente_personales', function (Blueprint $table) {
            $table->id();
            $table->string('patologias');
            $table->string('otras')->nullable();
            $table->string('tipo')->nullable();
            $table->date('fecha_diagnostico')->nullable();
            $table->string('cual')->nullable();
            $table->text('descripcion')->nullable();
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
        Schema::dropIfExists('antecedente_personales');
    }
};
