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
        Schema::create('ingreso_concurrencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->dateTime('fecha_ingreso')->nullable();
            $table->foreignId('cie10_id')->nullable()->constrained('cie10s');
            $table->string('tipo_hospitalizacion')->nullable();
            $table->string('unidad_funcional')->nullable();
            $table->string('via_ingreso')->nullable();
            $table->string('reingreso_15_dias')->nullable();
            $table->string('reingreso_30_dias')->nullable();
            $table->foreignId('rep_id')->nullable()->constrained('reps');
            $table->string('cama_piso')->nullable();
            $table->string('codigo_hospitalizacion')->nullable();
            $table->string('estancia_total')->nullable();
            $table->foreignId('especialidad_id')->nullable()->constrained('especialidades');
            $table->string('peso_neonato')->nullable();
            $table->string('edad_gestacional')->nullable();
            $table->text('nota_seguimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso_concurrencias');
    }
};
