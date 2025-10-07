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
        Schema::table('glosas', function (Blueprint $table) {
            $table->foreignId('am_id')->nullable()->constrained('ams');
            $table->foreignId('at_id')->nullable()->constrained('ats');
            $table->foreignId('ap_id')->nullable()->constrained('aps');
            $table->foreignId('ac_id')->nullable()->constrained('acs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('glosas', function (Blueprint $table) {
            $table->foreignId('am_id')->nullable()->constrained('ams');
            $table->foreignId('at_id')->nullable()->constrained('ats');
            $table->foreignId('ap_id')->nullable()->constrained('aps');
            $table->foreignId('ac_id')->nullable()->constrained('acs');
        });
    }
};
