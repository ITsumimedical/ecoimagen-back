<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registro_escala_abreviada_desarrollos', function (Blueprint $table) {
            $table->renameColumn('interpretacion_resultado', 'interpretacion_motricidad_gruesa');
            $table->string('interpretacion_finoadaptativa')->nullable();
            $table->string('interpretacion_audicion_lenguaje')->nullable();
            $table->string('interpretacion_persona_social')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('registro_escala_abreviada_desarrollos', function (Blueprint $table) {
            $table->renameColumn('interpretacion_motricidad_gruesa', 'interpretacion_resultado');
            $table->dropColumn('interpretacion_finoadaptativa');
            $table->dropColumn('interpretacion_audicion_lenguaje');
            $table->dropColumn('interpretacion_persona_social');
        });
    }
};