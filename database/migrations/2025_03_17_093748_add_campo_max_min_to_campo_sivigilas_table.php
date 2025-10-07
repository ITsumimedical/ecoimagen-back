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
        Schema::table('campo_sivigilas', function (Blueprint $table) {
            $table->boolean('max')->default(false);
            $table->boolean('min')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campo_sivigilas', function (Blueprint $table) {
            $table->dropColumn('max');
            $table->dropColumn('min');
        });
    }
};
