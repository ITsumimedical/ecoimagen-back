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
        Schema::table('salario_minimos', function (Blueprint $table) {
            $table->integer('cuota_moderadora_a')->nullable();
            $table->integer('cuota_moderadora_b')->nullable();
            $table->integer('cuota_moderadora_c')->nullable();
            $table->double('copago_a')->nullable();
            $table->double('copago_b')->nullable();
            $table->double('copago_c')->nullable();
            $table->integer('copago_tope_evento_a')->nullable();
            $table->integer('copago_tope_evento_b')->nullable();
            $table->integer('copago_tope_evento_c')->nullable();
            $table->integer('copago_tope_anual_a')->nullable();
            $table->integer('copago_tope_anual_b')->nullable();
            $table->integer('copago_tope_anual_c')->nullable();
            $table->double('copago_subsidiado')->nullable();
            $table->integer('copago_subsidiado_tope_evento')->nullable();
            $table->integer('copago_subsidiado_tope_anual')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
