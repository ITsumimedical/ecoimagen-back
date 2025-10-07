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
        Schema::table('afiliados', function (Blueprint $table) {
            $table->string('nivel_ensenanza')->nullable();
            $table->string('area_ensenanza_nombrado')->nullable();
            $table->string('escalafon')->nullable();
            $table->string('cargo')->nullable();
            $table->string('nombre_cargo')->nullable();
            $table->string('tipo_vinculacion')->nullable();
            $table->timestamp('fecha_expedicion_documento')->nullable();
            $table->timestamp('fecha_vigencia_documento')->nullable();
            $table->timestamp('fecha_defuncion')->nullable();
            $table->foreignId('tipo_documento_padre_beneficiario')->nullable()->constrained('tipo_documentos');
            $table->string('numero_documento_padre_beneficiario')->nullable();
            $table->string('tipo_nombramiento')->nullable();
            $table->string('gestante')->nullable();
            $table->string('semanas_gestacion')->nullable();
            $table->timestamp('fecha_posible_parto')->nullable();
            $table->string('grupo_poblacional')->nullable();
            $table->string('victima_conflicto_armado')->nullable();
            $table->string('zona_residencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('afiliados', function (Blueprint $table) {
            $table->dropColumn('nivel_ensenanza');
            $table->dropColumn('area_ensenanza_nombrado');
            $table->dropColumn('escalafon');
            $table->dropColumn('cargo');
            $table->dropColumn('nombre_cargo');
            $table->dropColumn('tipo_vinculacion');
            $table->dropColumn('fecha_expedicion_documento');
            $table->dropColumn('fecha_vigencia_documento');
            $table->dropColumn('fecha_defuncion');
            $table->dropForeign(['tipo_documento_padre_beneficiario']);
            $table->dropColumn('tipo_documento_padre_beneficiario');
            $table->dropColumn('numero_documento_padre_beneficiario');
            $table->dropColumn('tipo_nombramiento');
            $table->dropColumn('gestante');
            $table->dropColumn('semanas_gestacion');
            $table->dropColumn('fecha_posible_parto');
            $table->dropColumn('grupo_poblacional');
            $table->dropColumn('victima_conflicto_armado');
            $table->dropColumn('zona_residencia');
            $table->dropColumn('orden_judicial');
            $table->dropColumn('numero_folio');
            $table->dropColumn('fecha_folio');
            $table->dropColumn('proferido');
            $table->dropForeign(['cuidad_orden_judicial']);
            $table->dropColumn('cuidad_orden_judicial');
        });
    }
};
