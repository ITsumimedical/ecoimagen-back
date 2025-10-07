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
        Schema::table('ahs', function (Blueprint $table){
            $table->string('diagnostico_egreso')->nullable()->change();
            $table->string('diagnostico_ingreso')->nullable()->change();
            $table->string('diagnaostico_relacionado_1')->nullable()->change();
            $table->string('diagnaostico_relacionado_2')->nullable()->change();
            $table->string('diagnaostico_relacionado_3')->nullable()->change();
            $table->string('diagnostico_complicacion')->nullable()->change();
            $table->string('diagnostico_causa_muerte')->nullable()->change();
            $table->string('numero_documento')->nullable()->change();
            $table->string('tipo_documento')->nullable()->change();
            $table->string('numero_factura')->nullable()->change();
            $table->string('diagnostico_principal_ingreso')->nullable()->change();
            $table->string('diagnostico_principal_egreso')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ahs', function (Blueprint $table){
            $table->string('diagnostico_egreso')->nullable(false)->change();
            $table->string('diagnostico_ingreso')->nullable(false)->change();
            $table->string('diagnaostico_relacionado_1')->nullable(false)->change();
            $table->string('diagnaostico_relacionado_2')->nullable(false)->change();
            $table->string('diagnaostico_relacionado_3')->nullable(false)->change();
            $table->string('diagnostico_complicacion')->nullable(false)->change();
            $table->string('diagnostico_causa_muerte')->nullable(false)->change();
            $table->string('numero_documento')->nullable(false)->change();
            $table->string('tipo_documento')->nullable(false)->change();
            $table->string('numero_factura')->nullable(false)->change();
            $table->string('diagnostico_principal_ingreso')->nullable(false)->change();
            $table->string('diagnostico_principal_egreso')->nullable(false)->change();
        });
    }
};
