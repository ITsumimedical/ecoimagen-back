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
        Schema::create('ams', function (Blueprint $table) {
            $table->id();
            $table->string('numero_autorizacion')->nullable();
            $table->string('tipo_medicamento')->nullable();
            $table->string('numero_unidades')->nullable();
            $table->string('valor_unitario_medicamento')->nullable();
            $table->string('valor_total_medicamento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('numero_factura')->nullable();
            $table->string('codigo_prestador')->nullable();
            $table->string('codigo_medicamento')->nullable();
            $table->string('nombre_generico')->nullable();
            $table->string('forma_farmaceutica')->nullable();
            $table->string('concentracion_medicamento')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->foreignId('af_id')->nullable()->constrained('afs');
            $table->foreignId('paquete_rip_id')->constrained('paquete_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ams');
    }
};
