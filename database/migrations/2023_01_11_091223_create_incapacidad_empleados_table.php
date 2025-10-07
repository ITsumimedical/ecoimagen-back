<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIncapacidadEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidad_empleados', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->foreignId('cie10')->constrained('cie10s');
            $table->string('causa_externa')->nullable();
            $table->string('clase');
            $table->string('motivo')->nullable();
            $table->string('descripcion');
            $table->string('recomendaciones')->nullable();
            $table->foreignId('contrato_id')->constrained('contrato_empleados');
            $table->foreignId('estado_id')->constrained('estados');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->foreignId('incapacidad_id')->nullable()->constrained('incapacidad_empleados');
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
        Schema::dropIfExists('incapacidad_empleados');
    }
}
