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
        Schema::table('gestion_orden_prestador', function (Blueprint $table) {
            $table->date('fecha_asistencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestion_orden_prestador', function (Blueprint $table) {
            $table->date('fecha_asistencia')->nullable();
        });
    }
};
