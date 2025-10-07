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
        Schema::create('toma_procedimientos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_radicacion');
            $table->date('fecha_procedimiento')->nullable();
            $table->date('fecha_ingreso_muestra')->nullable();
            $table->date('fecha_salida_muestra')->nullable();
            $table->string('grado_infiltracion')->nullable();
            $table->string('grado_histologico')->nullable();
            $table->string('clasificacion_muestra')->nullable();
            $table->string('biopsia')->nullable();
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('organo_id')->nullable()->constrained('organos');
            $table->foreignId('estado_id')->default(10)->constrained('estados');
            $table->foreignId('cie10_id')->nullable()->constrained('cie10s');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('registrado_por_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toma_procedimientos');
    }
};
