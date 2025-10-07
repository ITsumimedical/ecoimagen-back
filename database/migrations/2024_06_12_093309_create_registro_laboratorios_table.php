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
        Schema::create('registro_laboratorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('cup_id')->nullable()->constrained('cups');
            $table->text('identificacion')->nullable();
            $table->text('codigo_cup')->nullable();
            $table->text('orden')->nullable();
            $table->text('grupo')->nullable();
            $table->text('cama')->nullable();
            $table->text('seccion')->nullable();
            $table->text('codigoexamen')->nullable();
            $table->text('nombrexamen')->nullable();
            $table->text('parametro')->nullable();
            $table->text('resultado')->nullable();
            $table->text('val_ref_1')->nullable();
            $table->text('val_ref_2')->nullable();
            $table->text('unidades')->nullable();
            $table->text('fecha_registro')->nullable();
            $table->text('fecha_validacion')->nullable();
            $table->text('servicio')->nullable();
            $table->text('codigo_centro')->nullable();
            $table->text('nombre_centro')->nullable();
            $table->text('codigomedico')->nullable();
            $table->text('nombre_medico')->nullable();
            $table->text('codigo_sede')->nullable();
            $table->text('nombre_sede')->nullable();
            $table->text('fecha_inicial')->nullable();
            $table->text('fecha_final')->nullable();
            $table->text('ips')->nullable();
            $table->text('primaria')->nullable();
            $table->text('ut')->nullable();
            $table->text('adjunto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_laboratorios');
    }
};
