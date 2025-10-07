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
        Schema::create('concurrencias', function (Blueprint $table) {
            $table->id();
            $table->float('costo_atencion')->nullable();
            $table->string('via_ingreso')->nullable();
            $table->string('reingreso_hospitalizacion15dias')->nullable();
            $table->string('reingreso_hospitalizacion30dias')->nullable();
            $table->string('unidad_funcional')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_egreso')->nullable();
            $table->string('destino_egreso')->nullable();
            $table->smallInteger('dias_estancia_observacion')->nullable()->default(0);
            $table->smallInteger('dias_estancia_intensivo')->nullable()->default(0);
            $table->smallInteger('dias_estancia_intermedio')->nullable()->default(0);
            $table->smallInteger('dias_estancia_basicos')->nullable()->default(0);
            $table->smallInteger('estancia_total')->nullable()->default(0);
            $table->string('especialidad_tratante')->nullable();
            $table->string('hospitalizacion_evitable')->nullable();
            $table->string('reporte_patologia_diagnostica')->nullable();
            $table->string('alto_costo')->nullable();
            $table->float('costo_total_global')->nullable();
            $table->string('numero_factura')->nullable();
            $table->string('tipo_hospitalizacion')->nullable();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('auditor_id')->constrained('users');
            $table->foreignId('dx_ingreso')->constrained('cie10s');
            $table->foreignId('dx_egreso')->nullable()->constrained('cie10s');
            $table->foreignId('dx_concurrencia')->nullable()->constrained('cie10s');
            $table->foreignId('referencia_id')->nullable()->constrained('referencias');
            $table->foreignId('ips_atencion')->nullable()->constrained('reps');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concurrencias');
    }
};
