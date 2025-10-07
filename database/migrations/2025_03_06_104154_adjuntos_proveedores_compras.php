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
        Schema::create('adjuntos_proveedores_compras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta_adjunto');
            $table->integer('tipo_adjunto');
            $table->foreignId('proveedor_id')->constrained('proveedores_compras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjuntos_proveedores_compras');
    }
};
