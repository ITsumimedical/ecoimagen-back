<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHomologosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homologos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tipo_manual_id');
            $table->string('cup_codigo');
            $table->string('descripcion');
            $table->float('uvr')->nullable();
            $table->float('valor_uvr')->nullable();
            $table->string('grupo_cx')->nullable();
            $table->float('valor_grupo_cx')->nullable();
            $table->string('puntaje_grupo_uvt')->nullable();
            $table->float('valor_uvt')->nullable();
            $table->float('valor');
            $table->boolean('estado')->default(true);
            $table->string('anio');
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
        Schema::dropIfExists('homologos');
    }
}
