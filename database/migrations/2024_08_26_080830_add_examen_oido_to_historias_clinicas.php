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
            $table->text('estado_oido')->nullable();
            $table->text('tamizacion_depresion')->nullable();
            $table->text('tamizacion_trastornos_ansiedad')->nullable();
            $table->text('test_audit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->text('estado_oido')->nullable();
            $table->text('tamizacion_depresion')->nullable();
            $table->text('tamizacion_trastornos_ansiedad')->nullable();
            $table->text('test_audit')->nullable();
        });
    }
};
