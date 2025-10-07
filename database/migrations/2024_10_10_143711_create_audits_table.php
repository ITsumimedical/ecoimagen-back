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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->string('frecuencia_consume_alcohol');
            $table->string('cuantas_bebidas_consume_en_dia');
            $table->string('frecuencia_toma_5_o_mas_bebidas_alcoholicas');
            $table->string('frecuencia__incapaz_beber');
            $table->string('frecuencia_no_atiende_obligaciones');
            $table->string('frecuencia__necesitado_beber_ayunas');
            $table->string('frecuencia_remordimientos_sentimientos_luego_beber');
            $table->string('frecuencia_no_recuerda_sucedido_noche_anterior');
            $table->string('persona_herida_por_beber');
            $table->string('familiar_amigo_muestra_preocupacion_por_consumo');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
