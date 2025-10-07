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
        Schema::create('parametrizacion_plan_cuidado_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parametrizacion_plan_cuidado_id')->constrained('parametrizacion_plan_cuidados');
            $table->foreignId('codesumi_id')->constrained('codesumis');
            $table->string('presentacion');
            $table->string('via');
            $table->integer('dosis');
            $table->integer('frecuencia');
            $table->string('unidad_tiempo');
            $table->integer('duracion');
            $table->integer('meses');
            $table->integer('cantidad_medico');
            $table->text('observaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametrizacion_plan_cuidado_detalles');
    }
};
