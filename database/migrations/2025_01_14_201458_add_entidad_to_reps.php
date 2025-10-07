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
        Schema::table('reps', function (Blueprint $table) {
            $table->foreignId('entidad_id')->nullable()->constrained('entidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reps', function (Blueprint $table) {
            $table->dropForeign('entidad_id');
            $table->dropColumn('entidad_id');
        });
    }
};
