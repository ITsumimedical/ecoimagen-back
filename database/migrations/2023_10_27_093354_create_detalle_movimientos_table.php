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
        Schema::create('detalle_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movimiento_id')->constrained('movimientos');
            $table->foreignId("bodega_medicamento_id")->nullable()->constrained("bodega_medicamentos");
            $table->float('cantidad_anterior')->nullable();
            $table->float('cantidad_solicitada')->nullable();
            $table->float('cantidad_final')->nullable();
            $table->float('precio_unidad')->nullable();
            $table->float('valor_total')->nullable();
            $table->float('valor_promedio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_movimientos');
    }
};
