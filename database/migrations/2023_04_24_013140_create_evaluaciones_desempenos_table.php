<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEvaluacionesDesempenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluaciones_desempenos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicial_periodo');
            $table->date('fecha_final_periodo');
            $table->boolean('inicio_evaluacion')->default(1);
            $table->foreignId('th_tipo_plantilla_id')->constrained('th_tipo_plantillas');
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->boolean('esta_activo')->default(1);
            $table->string('resultado')->nullable();
            $table->foreignId('evaluador_id')->references('id')->on('users');
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
        Schema::dropIfExists('evaluaciones_desempenos');
    }
}
