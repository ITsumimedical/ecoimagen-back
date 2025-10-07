<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSolicitudBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_bodegas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_solicitud_bodega_id')->constrained('tipo_solicitud_bodegas');
            $table->foreignId('bodega_origen_id')->constrained('bodegas');
            $table->foreignId('bodega_destino_id')->nullable()->constrained('bodegas');
            $table->foreignId('usuario_solicita_id')->constrained('users');
            $table->foreignId('usuario_aprueba_id')->nullable()->constrained('users');
            $table->foreignId('usuario_ejecuta_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('solicitud_bodegas');
    }
}
