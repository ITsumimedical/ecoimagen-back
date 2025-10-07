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
            $table->text('avcc_ojoderecho', 5000)->nullable();
            $table->text('avcc_ojoizquierdo', 5000)->nullable();
            $table->text('avsc_ojoderecho', 5000)->nullable();
            $table->text('avsc_ojoizquierdo', 5000)->nullable();
            $table->text('ph_ojoderecho', 5000)->nullable();
            $table->text('ph_ojoizquierdo', 5000)->nullable();
            $table->text('motilidad_ojoderecho', 5000)->nullable();
            $table->text('covert_ojoderecho', 5000)->nullable();
            $table->text('motilidad_ojoizquierdo', 5000)->nullable();
            $table->text('covert_ojoizquierdo', 5000)->nullable();
            $table->text('biomicros_ojoderecho', 5000)->nullable();
            $table->text('biomicros_ojoizquierdo', 5000)->nullable();
            $table->text('presionintra_ojoderecho', 5000)->nullable();
            $table->text('presionintra_ojoizquierdo', 5000)->nullable();
            $table->text('gionios_ojoderecho', 5000)->nullable();
            $table->text('gionios_ojoizquierdo', 5000)->nullable();
            $table->text('fondo_ojoderecho', 5000)->nullable();
            $table->text('fondo_ojoizquierdo', 5000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->text('avcc_ojoderecho', 5000)->nullable();
            $table->text('avcc_ojoizquierdo', 5000)->nullable();
            $table->text('avsc_ojoderecho', 5000)->nullable();
            $table->text('avsc_ojoizquierdo', 5000)->nullable();
            $table->text('ph_ojoderecho', 5000)->nullable();
            $table->text('ph_ojoizquierdo', 5000)->nullable();
            $table->text('motilidad_ojoderecho', 5000)->nullable();
            $table->text('covert_ojoderecho', 5000)->nullable();
            $table->text('motilidad_ojoizquierdo', 5000)->nullable();
            $table->text('covert_ojoizquierdo', 5000)->nullable();
            $table->text('biomicros_ojoderecho', 5000)->nullable();
            $table->text('biomicros_ojoizquierdo', 5000)->nullable();
            $table->text('presionintra_ojoderecho', 5000)->nullable();
            $table->text('presionintra_ojoizquierdo', 5000)->nullable();
            $table->text('gionios_ojoderecho', 5000)->nullable();
            $table->text('gionios_ojoizquierdo', 5000)->nullable();
            $table->text('fondo_ojoderecho', 5000)->nullable();
            $table->text('fondo_ojoizquierdo', 5000)->nullable();
        });
    }
};
