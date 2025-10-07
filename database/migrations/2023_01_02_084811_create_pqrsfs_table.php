<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePqrsfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pqrsfs', function (Blueprint $table) {
            $table->id();
            $table->string('reabierta')->nullable();
            $table->string('priorizacion')->nullable();
            $table->string('atr_calidad')->nullable();
            $table->string('prestador')->nullable();
            $table->string('procedente')->nullable();                    
            $table->string('ccgenera')->nullable();
            $table->string('nombregenera')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('tiposolicitud')->nullable();
            $table->string('canal')->nullable();
            $table->string('descripcion', 2000)->nullable();
            $table->string('pqr_codigo')->nullable();
            $table->string('fecha_creacion')->nullable();
            $table->string('afec_tipodoc')->nullable();
            $table->string('afec_numdoc')->nullable();
            $table->string('afec_nombres')->nullable();
            $table->string('afec_direccion')->nullable();
            $table->string('afec_municipio')->nullable();
            $table->string('afec_depto')->nullable();
            $table->string('pqr_estado')->nullable();
            $table->text('derecho')->nullable();
            $table->text('deber')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('afiliado_id')->constrained('afiliados');
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
        Schema::dropIfExists('pqrsfs');
    }
}
