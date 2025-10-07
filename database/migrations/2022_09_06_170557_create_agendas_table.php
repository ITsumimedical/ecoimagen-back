<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->dateTime('fecha_agendamiento')->nullable();
            $table->dateTime('fecha_solicitada_paciente')->nullable();
            $table->foreignId('consultorio_id')->constrained('consultorios');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('novedad_id')->nullable()->constrained('novedades');
            $table->foreignId('cup_id')->nullable()->constrained('cups');
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
        Schema::dropIfExists('agendas');
    }
}
