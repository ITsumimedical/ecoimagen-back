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
        Schema::create('acs', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_consulta');
            $table->string('numero_autorizacion')->nullable();
            $table->string('finalidad_consulta');
            $table->string('causa_externa');
            $table->string('codigo_relacionado1')->nullable();
            $table->string('codigo_relacionado2')->nullable();
            $table->string('codigo_relacionado3')->nullable();
            $table->string('tipo_diagnostico_principal');
            $table->string('valor_consulta');
            $table->string('valor_cuota_moderadora');
            $table->string('valor_neto_pagar');
            $table->string('numero_documento')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('numero_factura')->nullable();
            $table->string('codigo_prestador')->nullable();
            $table->string('consulta')->nullable();
            $table->string('diagnostico_principal')->nullable();
            $table->foreignId('paquete_rip_id')->nullable()->constrained('paquete_rips');
            $table->foreignId('af_id')->nullable()->constrained('afs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acs');
    }
};
