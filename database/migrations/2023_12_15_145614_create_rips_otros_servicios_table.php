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
        Schema::create('rips_otros_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rips_usuario_id')->constrained('rips_usuarios');
            $table->string('cantidadOS')->nullable();
            $table->string('codPrestador')->nullable();
            $table->string('codTecnologiaSalud')->nullable();
            $table->string('conceptoRecaudo')->nullable();
            $table->string('consecutivo')->nullable();
            $table->string('fechaSuministroTecnologia')->nullable();
            $table->string('idMIPRES')->nullable();
            $table->string('nomTecnologiaSalud')->nullable();
            $table->string('numAutorizacion')->nullable();
            $table->string('numDocumentoIdentificacion')->nullable();
            $table->string('numFEVPagoModerador')->nullable();
            $table->string('tipoDocumentoIdentificacion')->nullable();
            $table->string('tipoOS')->nullable();
            $table->string('valorPagoModerador')->nullable();
            $table->string('vrServicio')->nullable();
            $table->string('vrUnitOS')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rips_otros_servicios');
    }
};
