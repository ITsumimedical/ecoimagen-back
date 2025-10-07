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
        Schema::table('ams', function (Blueprint $table) {
            $table->foreignId('cum_id')->nullable()->constrained('cums');
            $table->foreignId('us_id')->nullable()->constrained('us');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ams', function (Blueprint $table) {
            $table->foreignId('cum_id')->nullable()->constrained('cums');
            $table->foreignId('us_id')->nullable()->constrained('us');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
        });
    }
};
