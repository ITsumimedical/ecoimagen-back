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
        Schema::table('teleapoyos', function (Blueprint $table) {
            $table->string('tipo_estrategia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teleapoyos', function (Blueprint $table) {
            $table->string('tipo_estrategia')->nullable();
        });
    }
};
