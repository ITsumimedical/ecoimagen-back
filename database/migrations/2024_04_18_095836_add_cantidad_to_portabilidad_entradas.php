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
        Schema::table('portabilidad_entradas', function (Blueprint $table) {
            $table->integer('cantidad_dias')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portabilidad_entradas', function (Blueprint $table) {
            $table->integer('cantidad_dias')->nullable();
        });
    }
};
