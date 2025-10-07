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
        Schema::table('cuestionario_vales', function (Blueprint $table) {

            $table->string('presencia_orejas')->nullable();
            $table->string('integridad_orejas')->nullable();
            $table->string('presencia_labios')->nullable();
            $table->string('integridad_labios')->nullable();
            $table->string('presencia_lengua')->nullable();
            $table->string('integridad_lengua')->nullable();
            $table->string('presencia_nariz')->nullable();
            $table->string('integridad_nariz')->nullable();
            $table->string('presencia_paladar')->nullable();
            $table->string('integridad_paladar')->nullable();
            $table->string('presencia_ojos')->nullable();
            $table->string('integridad_ojos')->nullable();
            $table->string('presencia_dientes')->nullable();
            $table->string('integridad_dientes')->nullable();
            $table->string('presencia_cuello')->nullable();
            $table->string('integridad_cuello')->nullable();
            $table->string('presencia_hombros')->nullable();
            $table->string('integridad_hombros')->nullable();
            $table->string('remision_urgente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuestionario_vales', function (Blueprint $table) {
            $table->dropColumn('presencia_orejas');
            $table->dropColumn('integridad_orejas');
            $table->dropColumn('presencia_labios');
            $table->dropColumn('integridad_labios');
            $table->dropColumn('presencia_lengua');
            $table->dropColumn('integridad_lengua');
            $table->dropColumn('presencia_nariz');
            $table->dropColumn('integridad_nariz');
            $table->dropColumn('presencia_paladar');
            $table->dropColumn('integridad_paladar');
            $table->dropColumn('presencia_ojos');
            $table->dropColumn('integridad_ojos');
            $table->dropColumn('presencia_dientes');
            $table->dropColumn('integridad_dientes');
            $table->dropColumn('presencia_cuello');
            $table->dropColumn('integridad_cuello');
            $table->dropColumn('presencia_hombros');
            $table->dropColumn('integridad_hombros');
            $table->dropColumn('remision_urgente');
        });
    }
};
