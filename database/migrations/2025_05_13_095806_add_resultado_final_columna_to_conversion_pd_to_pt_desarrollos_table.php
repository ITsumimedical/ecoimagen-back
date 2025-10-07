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
        Schema::table('conversion_pd_to_pt', function (Blueprint $table) {
            $table->string('resultado_final')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversion_pd_to_pt', function (Blueprint $table) {
            $table->dropColumn('resultado_final');
        });
    }
};
