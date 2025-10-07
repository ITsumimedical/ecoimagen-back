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
        Schema::create('rips_consultas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rips_usuario_id')->constrained('rips_usuarios');
            $table->string('causaMotivoAtencion')->nullable();
            $table->string('codConsulta')->nullable();
            $table->string('codDiagnosticoPrincipal')->nullable();
            $table->string('codDiagnosticoRelacionado1')->nullable();
            $table->string('codDiagnosticoRelacionado2')->nullable();
            $table->string('codDiagnosticoRelacionado3')->nullable();
            $table->string('codPrestador')->nullable();
            $table->string('codServicio')->nullable();
            $table->string('conceptoRecaudo')->nullable();
            $table->string('consecutivo')->nullable();
            $table->string('fechaInicioAtencion')->nullable();
            $table->string('finalidadTecnologiaSalud')->nullable();
            $table->string('grupoServicios')->nullable();
            $table->string('modalidadGrupoServicioTecSal')->nullable();
            $table->string('numAutorizacion')->nullable();
            $table->string('numDocumentoIdentificacion')->nullable();
            $table->string('numFEVPagoModerador')->nullable();
            $table->string('tipoDiagnosticoPrincipal')->nullable();
            $table->string('tipoDocumentoIdentificacion')->nullable();
            $table->string('valorPagoModerador')->nullable();
            $table->string('vrServicio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rips_consultas');
    }
};
