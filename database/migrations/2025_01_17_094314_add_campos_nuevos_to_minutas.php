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
        Schema::table('minutas', function (Blueprint $table) {
            $table->text('descripcion_tragos')->nullable();
            $table->boolean('desayuna_sino')->nullable();
            $table->text('observaciones_desayuno')->nullable();
            $table->boolean('mm_sino')->nullable();
            $table->text('mm_descripcion')->nullable();
            $table->boolean('almuerzo_sino')->nullable();
            $table->text('descripcion_almuerzo')->nullable();
            $table->boolean('algo_sino')->nullable();
            $table->text('descripcion_algo')->nullable();
            $table->boolean('comida_sino')->nullable();
            $table->text('comida_descripcion')->nullable();
            $table->boolean('merienda_sino')->nullable();
            $table->text('descripcion_merienda')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minutas', function (Blueprint $table) {
            $table->dropColumn('descripcion_tragos');
            $table->dropColumn('desayuna_sino');
            $table->dropColumn('observaciones_desayuno');
            $table->dropColumn('mm_sino');
            $table->dropColumn('mm_descripcion');
            $table->dropColumn('almuerzo_sino');
            $table->dropColumn('descripcion_almuerzo');
            $table->dropColumn('algo_sino');
            $table->dropColumn('descripcion_algo');
            $table->dropColumn('comida_sino');
            $table->dropColumn('comida_descripcion');
            $table->dropColumn('merienda_sino');
            $table->dropColumn('descripcion_merienda');
        });
    }
};
