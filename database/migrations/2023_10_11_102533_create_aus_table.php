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
        Schema::create('aus', function (Blueprint $table) {
            $table->id();
            $table->string('diagnostico_salida');
            $table->string('fecha_ingreso');
            $table->string('hora_ingreso');
            $table->string('Numero_autorizacion');
            $table->string('causa_externa');
            $table->string('diagnostico_relacion_salida1');
            $table->string('diagnostico_relacion_salida2');
            $table->string('diagnostico_relacion_salida3');
            $table->string('destino_usuario_salida');
            $table->string('estado_salida');
            $table->string('causa_basica_muerte');
            $table->string('fecha_salida_usuario');
            $table->string('hora_salida_usuario');
            $table->string('numero_documento');
            $table->string('tipo_documento');
            $table->string('numero_factura');
            $table->string('codigo_prestado');
            $table->string('diagnostico_principal_salida');
            $table->foreignId('paquete_rip_id')->constrained('paquete_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aus');
    }
};
