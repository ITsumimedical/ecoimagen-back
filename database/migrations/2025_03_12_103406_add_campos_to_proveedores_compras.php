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
        Schema::table('proveedores_compras', function (Blueprint $table) {
            $table->string('tipo_documento_legal')->nullable();
            $table->foreignId('pais_id')->nullable()->constrained('paises');
            $table->string('codigo_dian')->nullable();
            $table->string('responsabilidad_fiscal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedores_compras', function (Blueprint $table) {
            $table->dropColumn('tipo_documento_legal');
            $table->dropForeign(['pais_id']);
            $table->dropColumn('pais_id');
            $table->dropColumn('codigo_dian');
            $table->dropColumn('responsabilidad_fiscal');
        });
    }
};
