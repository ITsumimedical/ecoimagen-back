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
        Schema::table('concurrencias', function (Blueprint $table) {
            $table->foreignId('ingreso_concurrencia_id')->constrained('ingreso_concurrencias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concurrencias', function (Blueprint $table) {
            $table->foreignId('ingreso_concurrencia_id')->constrained('ingreso_concurrencias');
        });
    }
};
