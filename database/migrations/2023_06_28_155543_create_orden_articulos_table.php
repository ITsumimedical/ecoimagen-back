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
        Schema::create('orden_articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->foreignId('codesumi_id')->constrained('codesumis');
            $table->foreignId('estado_id')->constrained('estados');
            $table->integer('dosis');
            $table->integer('frecuencia');
            $table->string('unidad_tiempo');
            $table->integer('duracion');
            $table->integer('meses');
            $table->integer('cantidad_mensual');
            $table->integer('cantidad_mensual_disponible');
            $table->integer('cantidad_medico');
            $table->string('observacion');
            $table->date('fecha_vigencia');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_articulos');
    }
};
