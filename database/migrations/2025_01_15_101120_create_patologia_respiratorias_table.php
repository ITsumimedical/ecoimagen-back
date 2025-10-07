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
        Schema::create('patologia_respiratorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('creado_por')->constrained('users');
            $table->boolean('presenta_sindrome_apnea');
            $table->boolean('hipoapnea_obstructiva_sueno');
            $table->string('tipoApnea');
            $table->string('origen');
            $table->boolean('uso_cpap_bipap');
            $table->text('observacion_uso')->nullable();
            $table->boolean('adherencia_cpap_bipap');
            $table->text('observacion_adherencia')->nullable();
            $table->boolean('uso_oxigeno');
            $table->string('litro_oxigeno')->nullable();
            $table->string('clasificacion_control_asma');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patologia_respiratorias');
    }
};
