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
            $table->string('edad_gestacional_ecografia1')->nullable();
            $table->string('edad_gestacional_ecografia2')->nullable();
            $table->string('edad_gestacional_ecografia3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('edad_gestacional_ecografia1');
            $table->dropColumn('edad_gestacional_ecografia2');
            $table->dropColumn('edad_gestacional_ecografia3');
        });
    }
};
