<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTipoSolicitudBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_solicitud_bodegas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('auditoria')->nullable();
            $table->boolean('movimiento')->nullable();
            $table->foreignId('estado_id')->constrained('estados');
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
        Schema::dropIfExists('tipo_solicitud_bodegas');
    }
}
