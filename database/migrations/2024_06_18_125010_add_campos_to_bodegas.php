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
        Schema::table('bodegas', function (Blueprint $table) {
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('hora_inicio')->nullable();
            $table->string('hora_fin')->nullable();
            $table->integer('stock_seguridad')->nullable();
            $table->integer('tiempo_reposicion')->nullable();
            $table->integer('cobertura')->nullable();
            $table->foreignId('tipo_bodega_id')->nullable()->constrained('tipo_bodegas');
            $table->foreignId('municipio_id')->nullable()->constrained('municipios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bodegas', function (Blueprint $table) {
            //
        });
    }
};
