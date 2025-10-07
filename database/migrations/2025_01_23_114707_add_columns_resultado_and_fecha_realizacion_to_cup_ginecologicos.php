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
        Schema::table('cup_ginecologicos', function (Blueprint $table) {
            $table->string('resultados')->nullable();
            $table->date('fecha_realizacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cup_ginecologicos', function (Blueprint $table) {
            $table->dropColumn('resultados');
            $table->dropColumn('fecha_realizacion');
        });
    }
};
