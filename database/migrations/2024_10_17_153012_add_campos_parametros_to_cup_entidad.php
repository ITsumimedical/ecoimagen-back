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
        Schema::table('cup_entidad', function (Blueprint $table) {
            $table->boolean('diagnostico_requerido')->default(true);
            $table->integer('nivel_ordenamiento')->nullable();
            $table->integer('nivel_portabilidad')->nullable();
            $table->boolean('requiere_auditoria')->default(false);
            $table->integer('periodicidad')->nullable();
            $table->integer('cantidad_max_ordenamiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cup_entidad', function (Blueprint $table) {
            $table->boolean('diagnostico_requerido')->default(true);
            $table->integer('nivel_ordenamiento')->nullable();
            $table->integer('nivel_portabilidad')->nullable();
            $table->boolean('requiere_auditoria')->default(false);
            $table->integer('periodicidad')->nullable();
            $table->integer('cantidad_max_ordenamiento')->nullable();
        });
    }
};
