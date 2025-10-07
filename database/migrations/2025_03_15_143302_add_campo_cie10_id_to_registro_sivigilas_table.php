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
        Schema::table('registro_sivigilas', function (Blueprint $table) {
            $table->foreignId('cie10_id')->constrained('cie10s');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_sivigilas', function (Blueprint $table) {
            $table->dropColumn('cie10_id');
        });
    }
};
