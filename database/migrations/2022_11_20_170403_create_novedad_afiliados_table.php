<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNovedadAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novedad_afiliados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_novedad');
            $table->string('motivo');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tipo_novedad_afiliados_id')->constrained('tipo_novedad_afiliados');
            $table->foreignId('portabilidad_entrada_id')->nullable()->constrained('portabilidad_entradas');
            $table->foreignId('portabilidad_salida_id')->nullable()->constrained('portabilidad_salidas');
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('novedad_afiliados');
    }
}
