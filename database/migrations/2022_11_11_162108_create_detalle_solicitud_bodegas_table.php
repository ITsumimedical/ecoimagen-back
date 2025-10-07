<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDetalleSolicitudBodegasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_solicitud_bodegas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_bodega_id')->constrained('solicitud_bodegas');
            $table->foreignId('medicamento_id')->nullable()->constrained('medicamentos');
            $table->double("cantidad_inicial");
            $table->double("cantidad_aprobada")->nullable();
            $table->double("cantidad_entregada")->nullable();
            $table->double("precio_unidad_aprobado")->nullable();
            $table->double("precio_unidad_entrega")->nullable();
            $table->text("descripcion")->nullable();
            $table->string("lote")->nullable();
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
        Schema::dropIfExists('detalle_solicitud_bodegas');
    }
}
