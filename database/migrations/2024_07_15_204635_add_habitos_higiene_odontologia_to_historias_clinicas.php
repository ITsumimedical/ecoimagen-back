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
            $table->string('frecuencia_cepillado')->nullable();
            $table->string('realiza_higiene')->nullable();
            $table->string('uso_crema_dental')->nullable();
            $table->string('uso_seda_dental')->nullable();
            $table->string('uso_enjuague_bucal')->nullable();
            $table->string('uso_aparatologia_ortopedica')->nullable();
            $table->string('uso_adimentos_protesicos_removibles')->nullable();
            $table->string('higiene_aparatos_protesis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->string('frecuencia_cepillado')->nullable();
            $table->string('realiza_higiene')->nullable();
            $table->string('uso_crema_dental')->nullable();
            $table->string('uso_seda_dental')->nullable();
            $table->string('uso_enjuague_bucal')->nullable();
            $table->string('uso_aparatologia_ortopedica')->nullable();
            $table->string('uso_adimentos_protesicos_removibles')->nullable();
            $table->string('higiene_aparatos_protesis')->nullable();
        });
    }
};
