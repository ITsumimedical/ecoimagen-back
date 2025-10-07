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
        Schema::table('cuestionario_vales', function (Blueprint $table) {
            $table->integer('valorItemC')->nullable();
            $table->integer('valorItemE')->nullable();
            $table->integer('valorItemI')->nullable();
            $table->integer('valorItemV')->nullable();
            $table->string('observacionesItems')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuestionario_vales', function (Blueprint $table) {
            $table->dropColumn('valorItemC');
            $table->dropColumn('valorItemE');
            $table->dropColumn('valorItemI');
            $table->dropColumn('valorItemV');
            $table->dropColumn('observacionesItems');
        });
    }
};
