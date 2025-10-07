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
        Schema::create('rips_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rips_transaccion_id')->constrained('rips_transacciones');
            $table->string('codMunicipioResidencia')->nullable();
            $table->string('codPaisOrigen')->nullable();
            $table->string('codPaisResidencia')->nullable();
            $table->string('codSexo')->nullable();
            $table->string('codZonaTerritorialResidencia')->nullable();
            $table->string('consecutivo')->nullable();
            $table->string('fechaNacimiento')->nullable();
            $table->string('incapacidad')->nullable();
            $table->string('numDocumentoIdentificacion')->nullable();
            $table->string('tipoDocumentoIdentificacion')->nullable();
            $table->string('tipoUsuario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rips_usuarios');
    }
};
