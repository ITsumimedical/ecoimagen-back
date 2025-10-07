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
            $table->boolean('medicamento_vital')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codesumis', function (Blueprint $table) {
                $table->dropColumn('medicamento_vital');
        });
    }
};
