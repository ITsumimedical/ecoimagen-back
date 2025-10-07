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
        Schema::create('registro_recepcion_ordenes_interoperabilidad', function (Blueprint $table) {
            $table->id();
            $table->integer('orden_interoperabilidad_id');
            $table->integer('orden_articulo_interoperabilidad_id')->nullable();
            $table->integer('orden_procedimiento_interoperabilidad_id')->nullable();
            $table->boolean('estado');
            $table->text('mensaje_error')->nullable();
            $table->jsonb('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_recepcion_ordenes_interoperabilidad');
    }
};
