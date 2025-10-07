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
        Schema::create('rips_hospitalizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rips_usuario_id')->constrained('rips_usuarios');
            $table->string('causaMotivoAtencion')->nullable();
            $table->string('codComplicacion')->nullable();
            $table->string('codDiagnosticoCausaMuerte')->nullable();
            $table->string('codDiagnosticoPrincipal')->nullable();
            $table->string('codDiagnosticoPrincipalE')->nullable();
            $table->string('codDiagnosticoRelacionadoE1')->nullable();
            $table->string('codDiagnosticoRelacionadoE2')->nullable();
            $table->string('codDiagnosticoRelacionadoE3')->nullable();
            $table->string('codPrestador')->nullable();
            $table->string('condicionDestinoUsuarioEgreso')->nullable();
            $table->string('consecutivo')->nullable();
            $table->string('fechaEgreso')->nullable();
            $table->string('fechaInicioAtencion')->nullable();
            $table->string('numAutorizacion')->nullable();
            $table->string('viaIngresoServicioSalud')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rips_hospitalizacion');
    }
};
