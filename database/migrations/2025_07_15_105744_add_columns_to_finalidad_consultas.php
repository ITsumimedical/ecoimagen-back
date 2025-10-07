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
        Schema::table('finalidad_consultas', function (Blueprint $table) {
            $table->boolean('consultas')->nullable();
            $table->boolean('procedimientos')->nullable();
            $table->boolean('hospitalización')->nullable();
            $table->boolean('urgencias')->nullable();
            $table->boolean('nacidos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finalidad_consultas', function (Blueprint $table) {
            $table->dropColumn([
                'consultas',
                'procedimientos',
                'hospitalización',
                'urgencias',
                'nacidos'
            ]);
        });
    }
};
