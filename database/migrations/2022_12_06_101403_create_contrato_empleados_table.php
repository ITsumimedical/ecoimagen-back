<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateContratoEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_empleados', function (Blueprint $table) {
            $table->id();
            $table->boolean('prerrogativa')->default(false);
            $table->text('descripcion_prerrogativa')->nullable();
            $table->date('fecha_inicio_prerrogativa')->nullable();
            $table->date('fecha_fin_prerrogativa')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->date('fecha_fin_periodo_prueba')->nullable();
            $table->integer('salario')->nullable();
            $table->string('jornada')->nullable();
            $table->string('adjunto')->nullable();
            $table->string('tipo_terminacion')->nullable();
            $table->string('motivo_terminacion')->nullable();
            $table->string('justa_causa')->nullable();
            $table->boolean('activo')->nullable();
            $table->string('numero_cuenta_bancaria')->nullable();
            $table->foreignId('banco_id')->nullable()->constrained('bancos');
            $table->foreignId('tipo_cuenta_id')->nullable()->constrained('tipo_cuenta_bancarias');
            $table->foreignId('tipo_contrato_id')->nullable()->constrained('tipo_contrato_ths');
            $table->foreignId('cargo_id')->nullable()->constrained('cargos');
            $table->foreignId('empleado_id')->nullable()->constrained('empleados');
            $table->foreignId('municipio_trabaja_id')->nullable()->constrained('municipios');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos');
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato_empleados');
    }
}
