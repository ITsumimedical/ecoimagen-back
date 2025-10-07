<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCapacitacionEmpleadoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_empleado_detalles', function (Blueprint $table) {
            $table->id();
            $table->boolean('asistio')->default(false);
            $table->float('calificacion_pre_test')->nullable();
            $table->float('calificacion_post_test');
            $table->foreignId('capacitacion_id')->constrained('capacitacion_empleados');
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
        Schema::dropIfExists('capacitacion_empleado_detalles');
    }
}
