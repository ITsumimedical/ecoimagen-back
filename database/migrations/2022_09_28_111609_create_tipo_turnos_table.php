<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_turnos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('prefijo', 3);
            $table->string('color', 6);
            $table->string('imagen')->nullable();
            $table->integer('prioridad');
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
        Schema::dropIfExists('tipo_turnos');
    }
}
