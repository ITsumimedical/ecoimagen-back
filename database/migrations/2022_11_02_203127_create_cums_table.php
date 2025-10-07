<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cums', function (Blueprint $table) {
            $table->id();
            $table->string("expediente", 1000)->nullable();
            $table->string("producto", 1000)->nullable();
            $table->string("titular", 1000)->nullable();
            $table->string("registro_sanitario", 1000)->nullable();
            $table->string("fecha_expedicion", 1000)->nullable();
            $table->string("fecha_vencimiento", 1000)->nullable();
            $table->string("estado_registro", 1000)->nullable();
            $table->string("expediente_cum", 1000)->nullable();
            $table->string("consecutivo_cum", 1000)->nullable();
            $table->string("cantidad_cum", 1000)->nullable();
            $table->string("descripcion_comercial", 1000)->nullable();
            $table->string("estado_cum", 1000)->nullable();
            $table->string("fecha_activo", 1000)->nullable();
            $table->string("fecha_inactivo", 1000)->nullable();
            $table->string("muestra_medica", 1000)->nullable();
            $table->string("unidad", 1000)->nullable();
            $table->string("atc", 1000)->nullable();
            $table->string("descripcion_atc", 1000)->nullable();
            $table->string("via_administracion", 1000)->nullable();
            $table->string("concentracion", 1000)->nullable();
            $table->string("principio_activo", 1000)->nullable();
            $table->string("unidad_medida", 1000)->nullable();
            $table->string("cantidad", 1000)->nullable();
            $table->string("unidad_referencia", 1000)->nullable();
            $table->string("forma_farmaceutica", 1000)->nullable();
            $table->string("nombre_rol", 1000)->nullable();
            $table->string("tipo_rol", 1000)->nullable();
            $table->string("modalidad", 1000)->nullable();
            $table->string("cum_validacion", 1000)->nullable();
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
        Schema::dropIfExists('cums');
    }
}
