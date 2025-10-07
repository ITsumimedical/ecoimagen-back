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
        Schema::create('resultado_annarlabs', function (Blueprint $table) {
            $table->id();
            $table->integer('num_orden')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('documento')->nullable();
            $table->string('codigo_examen')->nullable();
            $table->integer('numero_peticion')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->string('codigo_analito')->nullable();
            $table->string('nombre_analito')->nullable();
            $table->string('resultado')->nullable();
            $table->string('valor_minimo')->nullable();
            $table->string('valor_maximo')->nullable();
            $table->string('unidades')->nullable();
            $table->string('usuario_valida')->nullable();
            $table->smallInteger('estado')->nullable();
            $table->string('id_laboratorio')->nullable();
            $table->string('descripcion_valor_referencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_annarlabs');
    }
};
