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
        Schema::create('antecedentes_farmacologicos', function (Blueprint $table) {
            $table->id();
            $table->string('alimento')->nullable();
            $table->string('ambiental')->nullable();
            $table->string('otras')->nullable();
            $table->text('observacion_ambiental')->nullable();
            $table->text('observacion_alimento')->nullable();
            $table->text('observacion_otro')->nullable();
            $table->text('observacion_medicamento')->nullable();
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('medicamento_id')->nullable()->constrained('medicamentos');
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
        Schema::dropIfExists('antecedentes_farmacologicos');
    }
};
