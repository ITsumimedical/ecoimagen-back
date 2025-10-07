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
        Schema::create('rips_recien_nacidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rips_usuario_id')->constrained('rips_usuarios');
            $table->string('codDiagnosticoCausaMuerte')->nullable();
            $table->string('codDiagnosticoPrincipal')->nullable();
            $table->string('codPrestador')->nullable();
            $table->string('codSexoBiologico')->nullable();
            $table->string('condicionDestinoUsuarioEgreso')->nullable();
            $table->string('consecutivo')->nullable();
            $table->string('edadGestacional')->nullable();
            $table->string('fechaEgreso')->nullable();
            $table->string('fechaNacimiento')->nullable();
            $table->string('numConsultasCPrenatal')->nullable();
            $table->string('numDocumentoIdentificacion')->nullable();
            $table->string('peso')->nullable();
            $table->string('tipoDocumentoIdentificacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rips_recien_nacidos');
    }
};
