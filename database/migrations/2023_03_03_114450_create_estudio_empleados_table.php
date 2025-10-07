<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEstudioEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudio_empleados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_obtenido');
            $table->string('nivel_estudio');
            $table->string('institucion');
            $table->date('fecha_inicio');
            $table->date('fecha_graduacion');
            $table->boolean('prerrogativa')->nullable();
            $table->string('descripcion_prerrogativa')->nullable();
            $table->foreignId('empleado_id')->constrained('empleados');
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
        Schema::dropIfExists('estudio_empleados');
    }
}
