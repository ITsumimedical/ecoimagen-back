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
        Schema::table('componentes_historia_clinicas', function (Blueprint $table) {
            $table->boolean('escala')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('componentes_historia_clinicas', function (Blueprint $table) {
            $table->dropColumn('escala');
        });
    }
};
