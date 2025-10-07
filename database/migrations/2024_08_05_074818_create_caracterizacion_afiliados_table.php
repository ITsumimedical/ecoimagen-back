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
        Schema::create('caracterizacion_afiliados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->string('reaccion_alergica')->nullable();
            $table->string('vacunado_covid')->nullable();
            $table->string('ocupacion')->nullable();
            $table->string('nivel_escolar')->nullable();
            $table->string('orientacion_sexual')->nullable();
            $table->string('tipo_vivienda')->nullable();
            $table->integer('cantidad_personas_vive')->nullable();
            $table->string('estrato_socioeconomico')->nullable();
            $table->string('agua_alcantarillado')->nullable();
            $table->string('metodo_cocina')->nullable();
            $table->string('energia_electrica')->nullable();
            $table->string('accesibilidad_vivienda')->nullable();
            $table->string('seguridad_orden')->nullable();
            $table->string('etnia')->nullable();
            $table->string('tamizaje_prostata')->nullable();
            $table->string('metodo_planificacion')->nullable();
            $table->string('planeado_embarazo')->nullable();
            $table->string('citologia_ultimo_ano')->nullable();
            $table->string('tamizaje_mamografia')->nullable();
            $table->foreignId('tipo_violencia_id')->nullable()->constrained('tipo_violencias');
            $table->string('discapacidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracterizacion_afiliados');
    }
};
