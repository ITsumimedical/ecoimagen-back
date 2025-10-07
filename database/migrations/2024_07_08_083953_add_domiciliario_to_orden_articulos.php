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
        Schema::table('orden_articulos', function (Blueprint $table) {
            $table->boolean('a_domicilio')->nullable();
            $table->string('domiciliario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_articulos', function (Blueprint $table) {
            $table->boolean('a_domicilio')->nullable();
            $table->string('domiciliario')->nullable();
        });
    }
};
