<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCalificacionCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificacion_competencias', function (Blueprint $table) {
            $table->id();
            $table->integer('calificacion')->default(0);
            $table->foreignId('evaluaciones_desempeno_id')->constrained('evaluaciones_desempenos');
            $table->foreignId('th_competencia_id')->constrained('th_competencias');
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
        Schema::dropIfExists('calificacion_competencias');
    }
}
