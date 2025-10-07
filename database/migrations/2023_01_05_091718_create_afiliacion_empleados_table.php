<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAfiliacionEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afiliacion_empleados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_afiliacion');
            $table->date('fecha_fin_afiliacion')->nullable();
            $table->foreignId('prestador_id')->constrained('prestador_ths');
            $table->foreignId('contrato_id')->constrained('contrato_empleados');
            $table->boolean('estado');
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
        Schema::dropIfExists('afiliacion_empleados');
    }
}
