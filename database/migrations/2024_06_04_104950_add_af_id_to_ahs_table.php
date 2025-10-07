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
        Schema::table('ahs', function (Blueprint $table) {
            $table->foreignId('af_id')->nullable()->constrained('afs');
            $table->foreignId('us_id')->nullable()->constrained('us');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ahs', function (Blueprint $table) {
            $table->foreignId('af_id')->nullable()->constrained('afs');
            $table->foreignId('us_id')->nullable()->constrained('us');
        });
    }
};
