<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reps', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_habilitacion');
            $table->string('numero_sede');
            $table->string('codigo');
            $table->string('nombre');
            $table->string('tipo_zona')->nullable();
            $table->string('nivel_atencion')->nullable();
            $table->string('correo1');
            $table->string('correo2')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->string('direccion');
            $table->boolean('propia')->default(false);
            $table->boolean('sede_principal')->nullable();
            $table->foreignId('prestador_id')->constrained('prestadores');
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('reps');
    }
}
