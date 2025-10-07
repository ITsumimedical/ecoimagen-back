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
        Schema::create('detalle_esquemas', function (Blueprint $table) {
            $table->id();
            $table->float('dosis')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('indice_dosis')->nullable();
            $table->string('nivel_ordenamiento')->nullable();
            $table->string('via')->nullable();
            $table->string('dosis_formulada')->nullable();
            $table->string('descripcion_dosis')->nullable();
            $table->bigInteger('cantidad_aplicaciones')->nullable();
            $table->string('dias_aplicacion')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('frecuencia_duracion')->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('codesumi_id')->nullable()->constrained('codesumis');
            $table->foreignId('esquema_id')->nullable()->constrained('esquemas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_esquemas');
    }
};
