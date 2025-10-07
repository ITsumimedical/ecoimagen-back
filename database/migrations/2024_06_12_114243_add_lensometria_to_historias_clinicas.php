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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->string('lateralidad_od')->nullable();
            $table->string('esf_od')->nullable();
            $table->string('cyl_od')->nullable();
            $table->string('eje_od')->nullable();
            $table->string('add_od')->nullable();
            $table->string('lateralidad_oi')->nullable();
            $table->string('esf_oi')->nullable();
            $table->string('cyl_oi')->nullable();
            $table->string('eje_oi')->nullable();
            $table->string('add_oi')->nullable();
            $table->string('checkboxSC')->nullable();
            $table->string('checkboxCC')->nullable();
            $table->string('agudeza_od')->nullable();
            $table->string('agudezavp_od')->nullable();
            $table->string('agudeza_oi')->nullable();
            $table->string('agudezavp_oi')->nullable();
            $table->string('ocular_vl')->nullable();
            $table->string('ocular_vp')->nullable();
            $table->string('ocular_ppc')->nullable();
            $table->string('biomicroscopiaOd')->nullable();
            $table->string('biomicroscopiaOi')->nullable();
            $table->string('pioOd')->nullable();
            $table->string('pioOi')->nullable();
            $table->string('oftalmoscopiaOd')->nullable();
            $table->string('oftalmoscopiaOi')->nullable();
            $table->string('queratometria_od')->nullable();
            $table->string('queratometria_oi')->nullable();
            $table->string('refraccion_od')->nullable();
            $table->string('refraccionAv_od')->nullable();
            $table->string('refraccion_oi')->nullable();
            $table->string('refraccionAv_oi')->nullable();
            $table->string('subjetivo_od')->nullable();
            $table->string('subjetivoAv_od')->nullable();
            $table->string('subjetivo_oi')->nullable();
            $table->string('subjetivoAv_oi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->string('lateralidad_od')->nullable();
            $table->string('esf_od')->nullable();
            $table->string('cyl_od')->nullable();
            $table->string('eje_od')->nullable();
            $table->string('add_od')->nullable();
            $table->string('lateralidad_oi')->nullable();
            $table->string('esf_oi')->nullable();
            $table->string('cyl_oi')->nullable();
            $table->string('eje_oi')->nullable();
            $table->string('add_oi')->nullable();
            $table->string('checkboxSC')->nullable();
            $table->string('checkboxCC')->nullable();
            $table->string('agudeza_od')->nullable();
            $table->string('agudezavp_od')->nullable();
            $table->string('agudeza_oi')->nullable();
            $table->string('agudezavp_oi')->nullable();
            $table->string('ocular_vl')->nullable();
            $table->string('ocular_vp')->nullable();
            $table->string('ocular_ppc')->nullable();
            $table->string('biomicroscopiaOd')->nullable();
            $table->string('biomicroscopiaOi')->nullable();
            $table->string('pioOd')->nullable();
            $table->string('pioOi')->nullable();
            $table->string('oftalmoscopiaOd')->nullable();
            $table->string('oftalmoscopiaOi')->nullable();
            $table->string('queratometria_od')->nullable();
            $table->string('queratometria_oi')->nullable();
            $table->string('refraccion_od')->nullable();
            $table->string('refraccionAv_od')->nullable();
            $table->string('refraccion_oi')->nullable();
            $table->string('refraccionAv_oi')->nullable();
            $table->string('subjetivo_od')->nullable();
            $table->string('subjetivoAv_od')->nullable();
            $table->string('subjetivo_oi')->nullable();
            $table->string('subjetivoAv_oi')->nullable();
        });
    }
};
