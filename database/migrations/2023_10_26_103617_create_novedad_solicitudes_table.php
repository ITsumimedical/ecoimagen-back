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
        Schema::create('novedad_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_novedad_solicitud_id')->constrained('tipo_novedad_solicitudes');
            $table->foreignId('medicamento_id')->nullable()->constrained('medicamentos');
            $table->foreignId('detalle_solicitud_bodega_id')->constrained('detalle_solicitud_bodegas');
            $table->float('precio')->nullable();
            $table->float('cantidad')->nullable();
            $table->text('observacion')->nullable();
            $table->boolean('devolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedad_solicitudes');
    }
};
