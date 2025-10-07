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
        Schema::table('cup_entidad', function (Blueprint $table) {
            $table->boolean('copago')->default(false);
            $table->boolean('moderadora')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cup_entidad', function (Blueprint $table) {
            $table->boolean('copago')->default(false);
            $table->boolean('moderadora')->default(false);
        });
    }
};
