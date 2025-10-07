<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateActuacionTutelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actuacion_tutelas', function (Blueprint $table) {
            $table->id();
            $table->string('direccion')->nullable();
            $table->bigInteger('telefono')->nullable();
            $table->bigInteger('celular')->nullable();
            $table->bigInteger('dias')->nullable();
            $table->string('correo')->nullable();
            $table->string('continuidad')->nullable();
            $table->string('exclusion')->nullable();
            $table->string('integralidad')->nullable();
            $table->string('novedad_registro')->nullable();
            $table->string('gestion_documental')->nullable();
            $table->string('medicina_laboral')->nullable();
            $table->string('reembolso')->nullable();
            $table->string('transporte')->nullable();
            $table->string('reintegro_laboral')->nullable();
            $table->string('hospitalizacion')->nullable();
            $table->date('fecha_radica')->nullable();
            $table->date('fecha_cerrada')->nullable();
            $table->text('observacion')->nullable();
            $table->foreignId('tipo_actuacion_id')->constrained('tipo_actuaciones');
            $table->foreignId('quien_creo_id')->constrained('users');
            $table->foreignId('tutela_id')->default(1)->constrained('tutelas');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
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
        Schema::dropIfExists('actuacion_tutelas');
    }
}
