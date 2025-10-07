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
        Schema::create('log_sismas', function (Blueprint $table) {
            $table->id();
            $table->string('estudio')->nullable();
            $table->string('idSede');
            $table->string('autoId');
            $table->string('codigoEmpresa');
            $table->string('codigoClasificacion');
            $table->string('fechaIngreso')->nullable();
            $table->string('horaIngreso')->nullable();
            $table->string('codigoMedico');
            $table->string('contrato');
            $table->string('idPuntoAtencion');
            $table->string('codigo');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->string('valor');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_sismas');
    }
};
