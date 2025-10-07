<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVacacionEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacacion_empleados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio_disfrute');
            $table->date('fecha_fin_disfrute');
            $table->string('anio_periodo');
            $table->date('fecha_incorporacion');
            $table->integer('dias_disfrutados');
            $table->integer('dias_pagados');
            $table->boolean('requiere_reemplazo')->nullable()->default(false);
            $table->foreignId('contrato_id')->constrained('contrato_empleados');
            $table->foreignId('estado_id')->constrained('estados');
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
        Schema::dropIfExists('vacacion_empleados');
    }
}
