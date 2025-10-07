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
        Schema::create('historico_contrato_empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_empleado_id')->constrained('contrato_empleados');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('cargo_id')->nullable()->constrained('cargos');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos');
            $table->foreignId('tipo_contrato_id')->nullable()->constrained('tipo_contrato_ths');
            $table->integer('salario')->nullable();
            $table->integer('horas')->nullable();
            $table->string('accion');
            $table->text('observaciones');
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->date('fecha_fin_periodo_prueba')->nullable();
            $table->date('fecha_aplicacion_novedad')->nullable();
            $table->string('jornada')->nullable();
            $table->boolean('activo')->nullable();
            $table->string('tipo_terminacion')->nullable();
            $table->string('motivo_terminacion')->nullable();
            $table->string('justa_causa')->nullable();
            $table->string('numero_cuenta_bancaria')->nullable();
            $table->string('municipio_trabaja_id')->nullable();
            $table->string('tipo_cuenta_id')->nullable();
            $table->string('banco_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_contrato_empleados');
    }
};
