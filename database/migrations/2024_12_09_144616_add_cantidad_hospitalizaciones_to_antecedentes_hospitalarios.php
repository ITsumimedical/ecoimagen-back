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
            $table->integer('cantidad_hospitalizaciones')->nullable();
            $table->string('hospitalizacion_uci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedentes_hospitalarios', function (Blueprint $table) {
            $table->dropColumn('cantidad_hospitalizaciones');
            $table->dropColumn('hospitalizacion_uci');
        });
    }
};
