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
        Schema::create('conducta_relacionamientos', function (Blueprint $table) {
            $table->id();
            $table->text('alimentacion');
            $table->text('higiene');
            $table->text('sueno');
            $table->text('independencia_personal');
            $table->text('actividad');
            $table->text('atencion');
            $table->text('impulsividad');
            $table->text('crisis_colericas');
            $table->text('adaptacion');
            $table->text('labilidad_emocional');
            $table->text('relaciones_familiares');
            $table->text('tiempo_libre');
            $table->text('ruidos_altos');
            $table->text('socializacion');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conducta_relacionamientos');
    }
};
