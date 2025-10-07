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
        Schema::table('recomendaciones', function (Blueprint $table) {
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->text('sexo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recomendaciones', function (Blueprint $table) {
            $table->dropColumn('edad_minima');
            $table->dropColumn('edad_maxima');
            $table->dropColumn('sexo');
        });
    }
};
