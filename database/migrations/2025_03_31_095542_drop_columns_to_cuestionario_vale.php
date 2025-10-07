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
            $table->dropColumn([
                'presencia_orejas',
                'presencia_labios',
                'presencia_lengua',
                'presencia_nariz',
                'presencia_paladar',
                'presencia_ojos',
                'presencia_dientes',
                'presencia_cuello',
                'presencia_hombros',
                'remision_urgente'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuestionario_vales', function (Blueprint $table) {
            $table->string('presencia_orejas')->nullable();
            $table->string('presencia_labios')->nullable();
            $table->string('presencia_lengua')->nullable();
            $table->string('presencia_nariz')->nullable();
            $table->string('presencia_paladar')->nullable();
            $table->string('presencia_ojos')->nullable();
            $table->string('presencia_dientes')->nullable();
            $table->string('presencia_cuello')->nullable();
            $table->string('presencia_hombros')->nullable();
            $table->string('remision_urgente')->nullable();
        });
    }
};
