<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->string('codigo_habilitacion');
            $table->string('nombre_prestador');
            $table->string('nit');
            $table->string('razon_social');
            $table->string('clase_prestador')->nullable();
            $table->string('empresa_social')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('correo1')->null();
            $table->string('nivel')->null();
            $table->string('caracter')->nullable();
            $table->string('naturaleza_juridica')->nullable();
            $table->string('telefono2')->nullable();
            $table->string('correo2')->nullable();
            $table->foreignId('tipo_prestador_id')->constrained('tipo_prestadores');
            $table->boolean('activo')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('prestadores');
    }
}
