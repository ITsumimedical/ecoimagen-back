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
        Schema::create('registrofacturasumimedicals', function (Blueprint $table) {
            $table->id();
            $table->integer('sede_atencion_id');
            $table->integer('afiliado_id');
            $table->integer('consulta_id');
            $table->string('codigo_empresa');
            $table->string('codigo_clasificacion');
            $table->date('fecha_ingreso');
            $table->time('hora_ingreso');
            $table->integer('medico_atiende_id');
            $table->string('contrato');
            $table->string('codigo_diagnostico');
            $table->string('codigo_cup');
            $table->string('descripcion_cup');
            $table->integer('cantidad_cup');
            $table->decimal('valor_cup', 10, 3);
            $table->integer('created_by')->nullable();
            $table->date('fecha_facturacion')->nullable();
            $table->string('numero_factura')->nullable();
            $table->boolean('estado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrofacturasumimedicals');
    }
};
