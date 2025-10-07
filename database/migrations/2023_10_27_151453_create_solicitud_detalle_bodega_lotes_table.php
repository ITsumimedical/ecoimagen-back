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
        Schema::create('solicitud_detalle_bodega_lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalle_solicitud_bodega_id')->constrained('detalle_solicitud_bodegas');
            $table->string('lote');
            $table->float('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_detalle_lotes_');
    }
};
