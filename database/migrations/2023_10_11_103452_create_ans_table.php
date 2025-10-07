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
        Schema::create('ans', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_nacimiento');
            $table->string('edad_gestional');
            $table->string('Hora_nacimiento');
            $table->string('gestion_prenatal');
            $table->string('sexo');
            $table->string('peso');
            $table->string('causa_muerte');
            $table->string('fecha_muerte');
            $table->string('hora_muerte');
            $table->string('documento_an');
            $table->string('tipo_an');
            $table->string('numero_documento');
            $table->string('tipo_documento');
            $table->string('numero_factura');
            $table->string('codigo_prestador');
            $table->string('diagnostico_recien_nacido');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->foreignId('paquete_rip_id')->constrained('paquete_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ans');
    }
};
