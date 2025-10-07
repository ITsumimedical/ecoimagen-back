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
        Schema::table('cambios_ordenes', function (Blueprint $table) {
            $table->foreignId('rep_nuevo_id')->nullable()->constrained('reps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cambios_ordenes', function (Blueprint $table) {
            $table->dropForeign(['rep_nuevo_id']);
            $table->dropColumn('rep_nuevo_id');
        });
    }
};
