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
        Schema::table('minutas', function (Blueprint $table) {
            $table->string('desayuno')->nullable()->change();
            $table->string('media_manana')->nullable()->change();
            $table->string('almuerzo')->nullable()->change();
            $table->string('comida')->nullable()->change();
            $table->string('merienda')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minutas', function (Blueprint $table) {
            $table->string('desayuno')->nullable(false)->change();
            $table->string('media_manana')->nullable(false)->change();
            $table->string('almuerzo')->nullable(false)->change();
            $table->string('comida')->nullable(false)->change();
            $table->string('merienda')->nullable(false)->change();
        });
    }
};
