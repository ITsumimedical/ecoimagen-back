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
        Schema::table('ingreso_concurrencias', function (Blueprint $table) {
            $table->date('fecha_ingreso')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingreso_concurrencias', function (Blueprint $table) {
            $table->dateTime('fecha_ingreso')->change();
        });
    }
};
