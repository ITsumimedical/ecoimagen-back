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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores');
            $table->foreignId('bodega_origen_id')->nullable()->constrained('bodegas');
            $table->foreignId('bodega_destino_id')->nullable()->constrained('bodegas');
            $table->foreignId('orden_id')->nullable()->constrained('ordenes');
            $table->foreignId('solicitud_bodega_id')->nullable()->constrained('solicitud_bodegas');
            $table->string('codigo_factura')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
