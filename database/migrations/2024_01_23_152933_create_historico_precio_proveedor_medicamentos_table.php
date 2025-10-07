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
        Schema::create('historico_precio_proveedor_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->float('precio_unidad');
            $table->foreignId('proveedor_id')->constrained('proveedores');
            $table->foreignId('medicamento_id')->constrained('medicamentos');
            $table->foreignId('solicitud_bodega_id')->nullable()->constrained('solicitud_bodegas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_precio_proveedor_medicamentos');
    }
};
