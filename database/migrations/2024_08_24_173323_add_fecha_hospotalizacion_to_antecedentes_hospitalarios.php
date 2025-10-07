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
        Schema::table('antecedentes_hospitalarios', function (Blueprint $table) {
            $table->date('fecha_ultimas_hospitalizaciones')->nullable();
            $table->date('segunda_fecha_ultimas_hospitalizaciones')->nullable();
            $table->date('tercera_fecha_ultimas_hospitalizaciones')->nullable();
            $table->date('fecha_hospitalizacion_uci_ultimo_ano')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedentes_hospitalarios', function (Blueprint $table) {
            $table->date('fecha_ultimas_hospitalizaciones')->nullable();
            $table->date('segunda_fecha_ultimas_hospitalizaciones')->nullable();
            $table->date('tercera_fecha_ultimas_hospitalizaciones')->nullable();
            $table->date('fecha_hospitalizacion_uci_ultimo_ano')->nullable();
        });
    }
};
