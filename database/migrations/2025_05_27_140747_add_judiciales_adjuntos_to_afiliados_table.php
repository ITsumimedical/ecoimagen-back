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
            // campos para registro judicial
            $table->string('orden_judicial')->nullable();
            $table->integer('numero_folio')->nullable();
            $table->date('fecha_folio')->nullable();
            $table->string('proferido')->nullable();
            $table->foreignId('cuidad_orden_judicial')->nullable()->constrained('municipios')->nullable();
            // campos para adjuntos afiliado
            $table->string('ruta_adj_doc_cotizante')->nullable();
            $table->string('ruta_adj_doc_beneficiario')->nullable();
            $table->string('ruta_adj_solic_firmada')->nullable();
            $table->string('ruta_adj_matrimonio')->nullable();
            $table->string('ruta_adj_rc_nacimiento_beneficiario')->nullable();
            $table->string('ruta_adj_rc_nacimiento_cotizante')->nullable();
            $table->string('ruta_adj_cert_discapacidad_hijo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('afiliados', function (Blueprint $table) {
            $table->dropForeign(['cuidad_orden_judicial']);
            $table->dropColumn([
                'orden_judicial',
                'numero_folio',
                'fecha_folio',
                'proferido',
                'cuidad_orden_judicial',
                'ruta_adj_doc_cotizante',
                'ruta_adj_doc_beneficiario',
                'ruta_adj_solic_firmada',
                'ruta_adj_matrimonio',
                'ruta_adj_rc_nacimiento_beneficiario',
                'ruta_adj_rc_nacimiento_cotizante',
                'ruta_adj_cert_discapacidad_hijo',
            ]);
        });
    }
};
