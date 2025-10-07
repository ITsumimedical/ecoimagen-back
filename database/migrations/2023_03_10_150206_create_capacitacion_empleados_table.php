<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCapacitacionEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacion_empleados', function (Blueprint $table) {
            $table->id();
            $table->string('hora_inicio');
            $table->string('hora_fin');
            $table->string('lugar_realizacion');
            $table->string('tema');
            $table->string('metodologia');
            $table->string('objetivo');
            $table->text('contenido');
            $table->string('capacitador');
            $table->foreignId('municipio_id')->constrained('municipios');
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
        Schema::dropIfExists('capacitacion_empleados');
    }
}
