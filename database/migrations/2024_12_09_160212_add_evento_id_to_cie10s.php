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
        Schema::table('cie10s', function (Blueprint $table) {
            $table->foreignId('evento_id')->nullable()->constrained('evento_sivigilas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cie10s', function (Blueprint $table) {
            $table->dropColumn('evento_id');
            $table->dropForeign(['evento_id']);
        });
    }
};
