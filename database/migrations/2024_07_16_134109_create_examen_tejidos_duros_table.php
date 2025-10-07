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
        Schema::create('examen_tejidos_duros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->text('sensibilidad_frio')->nullable();
            $table->text('sensibilidad_calor')->nullable();
            $table->text('cambio_de_color')->nullable();
            $table->text('percusion_positiva')->nullable();
            $table->text('exposicion_pulpar')->nullable();
            $table->text('otros')->nullable();
            $table->text('supernumerarios')->nullable();
            $table->text('agenesia')->nullable();
            $table->text('anodoncia')->nullable();
            $table->text('decoloracion')->nullable();
            $table->text('descalcificacion')->nullable();
            $table->text('facetas_desgaste')->nullable();
            $table->text('atricion')->nullable();
            $table->text('abrasion')->nullable();
            $table->string('fluorosis')->nullable();
            $table->text('protesis_fija')->nullable();
            $table->text('protesis_removible')->nullable();
            $table->text('protesis_total')->nullable();
            $table->text('implantes_dentales')->nullable();
            $table->text('aparatologia_ortopedica')->nullable();
            $table->text('inflamacion')->nullable();
            $table->text('sangrado')->nullable();
            $table->text('exudado')->nullable();
            $table->text('supuracion')->nullable();
            $table->text('placa_blanda')->nullable();
            $table->text('placa_calcificada')->nullable();
            $table->text('retracciones')->nullable();
            $table->text('presencia_bolsas')->nullable();
            $table->text('cuellos_sensibles')->nullable();
            $table->text('movilidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_tejidos_duros');
    }
};
