<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->timestamp('fecha_inicio')->nullable();

            $table->boolean('poliza')->defalt(false);
            $table->boolean('renovacion')->default(false);
            $table->boolean('modificacion')->default(false);

            $table->string('tipo_reporte')->nullable();
            $table->string('linea_negocio')->nullable();
            $table->string('regimen')->nullable();

            $table->string('documento_proveedor_id')->nullable();
            $table->string('documento_proveedor')->nullable();
            $table->string('naturaleza_juridica')->nullable();

            $table->string('codigo_habilitacion')->nullable();
            $table->string('componente')->nullable();
            $table->string('tipo_servicio')->nullable();

            $table->string('tipo_relacion')->nullable();
            $table->string('codigo_contrato')->nullable();
            $table->string('obj_contrato')->nullable();

            $table->integer('poblacion_cubierta')->nullable()->default(0);
            $table->string('modalidad_pago')->nullable();
            $table->string('otra_modalidad')->nullable();

            $table->string('tipo_modificacion')->nullable();
            $table->double('valor_contrato')->nullable();
            $table->double('valor_adicion')->nullable();

            $table->double('valor_ejecutado')->nullable();
            $table->string('estado')->nullable();
            $table->string('union_temporal')->nullable();

            $table->string('union_temporal_id')->nullable();
            $table->string('tipo_proveedor')->nullable();
            $table->string('tipo_red')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            //
        });
    }
};
