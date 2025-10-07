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
        Schema::create('evolucions', function (Blueprint $table) {
            $table->id();
            $table->text('subjetivo');
            $table->text('descripcion_fisica');
            $table->text('paraclinicos');
            $table->text('procedimiento');
            $table->text('analisis');
            $table->text('tratamiento');
            $table->string('peso')->nullable();
            $table->string('tension_arterial')->nullable();
            $table->string('frecuencia_respiratoria')->nullable();
            $table->string('frecuencia_cardiaca')->nullable();
            $table->string('temperatura')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('admision_urgencia_id')->constrained('admisiones_urgencias');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evolucions');
    }
};
