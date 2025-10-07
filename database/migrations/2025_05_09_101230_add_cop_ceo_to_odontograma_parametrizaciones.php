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
        Schema::table('odontograma_parametrizaciones', function (Blueprint $table) {
            $table->string('clasificacion_cop_ceo')->nullable();
            $table->string('informe_202')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('odontograma_parametrizaciones', function (Blueprint $table) {
            $table->dropColumn('clasificacion_cop_ceo');
            $table->dropColumn('informe_202');
        });
    }
};
