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
        Schema::table('cambios_ordenes', function (Blueprint $table) {
            $table->string('cantidad_anterior')->nullable();
            $table->string('accion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cambios_ordenes', function (Blueprint $table) {
            $table->string('cantidad_anterior')->nullable();
            $table->string('accion')->nullable();
        });
    }
};
