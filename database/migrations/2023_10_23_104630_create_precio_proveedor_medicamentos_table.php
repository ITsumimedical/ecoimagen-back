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
        Schema::create('precio_proveedor_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->float('precio_unidad');
            $table->float('iva')->nullable();
            $table->float('iva_facturacion')->nullable();
            $table->float('precio_venta')->nullable();
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('medicamento_id')->constrained('medicamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_proveedor_medicamentos');
    }
};
