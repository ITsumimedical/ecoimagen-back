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
        Schema::create('evento_adversos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_ocurrencia');
            $table->text('descripcion_hechos');
            $table->text('accion_tomada');
            $table->string('dosis')->nullable();
            $table->string('frecuencia_administracion')->nullable();
            $table->string('servicio_ocurrencia')->nullable();
            $table->string('tiempo_infusion')->nullable();
            $table->string('otros_nombre_suceso')->nullable();
            $table->string('afiliado_id')->nullable();
            $table->foreignId('suceso_id')->constrained('sucesos');
            $table->foreignId('tipo_evento_id')->nullable()->constrained('tipo_eventos');
            $table->foreignId('profesional_id')->nullable()->constrained('users');
            $table->foreignId('sede_ocurrencia_id')->constrained('reps');
            $table->foreignId('sede_reportante_id')->constrained('reps');
            $table->foreignId('clasificacion_area_id')->nullable()->constrained('clasificacion_areas');
            $table->foreignId('medicamento_id')->nullable()->constrained('medicamentos');
            $table->foreignId('estado_id')->constrained('estados');
            $table->string('priorizacion')->nullable();
            $table->string('otros_motivo_anulacion')->nullable();
            $table->boolean('voluntariedad')->nullable()->default(false);
            $table->string('identificacion_riesgo')->nullable();
            $table->string('clasificacion_anulacion')->nullable();
            $table->foreignId('motivo_anulacion_id')->nullable()->constrained('motivo_anulacion_eventos');
            $table->foreignId('user_id')->nullable()->constrained('users');
            // tecnovigilancia - dispositivo
            $table->string('relacion')->nullable();
            $table->foreignId('dispositivo_id')->nullable()->constrained('codesumis');
            $table->string('referencia_dispositivo')->nullable();
            $table->string('marca_dispositivo')->nullable();
            $table->string('lote_dispositivo')->nullable();
            $table->string('invima_dispositivo')->nullable();
            // tecnovigilancia - equipo biomedico
            $table->string('nombre_equipo_biomedico')->nullable();
            $table->string('marca_equipo_biomedico')->nullable();
            $table->string('modelo_equipo_biomedico')->nullable();
            $table->string('serie_equipo_biomedico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_adversos');
    }
};
