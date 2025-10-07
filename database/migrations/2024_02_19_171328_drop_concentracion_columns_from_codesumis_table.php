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
        Schema::table('codesumis', function (Blueprint $table) {
            $table->dropColumn('concentracion_1');
            $table->dropColumn('concentracion_2');
            $table->dropColumn('concentracion_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codesumis', function (Blueprint $table) {
            $table->dropColumn('concentracion_1');
            $table->dropColumn('concentracion_2');
            $table->dropColumn('concentracion_3');
        });
    }
};
