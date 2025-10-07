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
        Schema::create('ahs', function (Blueprint $table) {
            $table->id();
            $table->string('via_ingreso');
            $table->string('fecha_ingreso');
            $table->string('hora_ingreso');
            $table->string('numero_autorizacion');
            $table->string('causa_externa');
            $table->string('diagnostico_ingreso');
            $table->string('diagnostico_egreso');
            $table->string('diagnaostico_relacionado_1');
            $table->string('diagnaostico_relacionado_2');
            $table->string('diagnaostico_relacionado_3');
            $table->string('diagnostico_complicacion');
            $table->string('estado_Salida');
            $table->string('diagnostico_causa_muerte');
            $table->string('fecha_egreso');
            $table->string('hora_egreso');
            $table->string('numero_documento');
            $table->string('tipo_documento');
            $table->string('numero_factura');
            $table->string('codigo_prestador');
            $table->string('diagnostico_principal_ingreso');
            $table->string('diagnostico_principal_egreso');
            $table->foreignId('paquete_rip_id')->constrained('paquete_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahs');
    }
};
