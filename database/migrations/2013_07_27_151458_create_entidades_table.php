<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEntidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('agendar_pacientes')->default(false);
            $table->boolean('entregar_medicamentos')->default(false);
            $table->boolean('atender_pacientes')->default(false);
            $table->boolean('autorizar_ordenes')->default(false);
            $table->boolean('consultar_historicos')->default(false);
            $table->boolean('generar_ordenes')->default(false);
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('entidades');
    }
}
