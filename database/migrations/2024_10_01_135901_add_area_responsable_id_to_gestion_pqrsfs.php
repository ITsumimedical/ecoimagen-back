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
        Schema::table('gestion_pqrsfs', function (Blueprint $table) {
            $table->foreignId('area_responsable_id')->nullable()->constrained('area_responsable_pqrsfs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestion_pqrsfs', function (Blueprint $table) {
            $table->dropForeign(['area_responsable_id']);
            $table->dropColumn('area_responsable_id');
        });
    }
};
