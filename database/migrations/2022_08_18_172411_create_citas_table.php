<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->bigInteger('cantidad_paciente');
            $table->bigInteger('tiempo_consulta');
            $table->boolean('sms');
            $table->boolean('requiere_orden');
            $table->foreignId('especialidade_id')->constrained('especialidades');
            $table->foreignId('tipo_cita_id')->constrained('tipo_citas');
            $table->foreignId('primera_vez_cup_id')->nullable()->constrained('cups');
            $table->foreignId('control_cup_id')->nullable()->constrained('cups');
            $table->foreignId('modalidad_id')->nullable()->constrained('modalidades');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
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
        Schema::dropIfExists('citas');
    }
}
