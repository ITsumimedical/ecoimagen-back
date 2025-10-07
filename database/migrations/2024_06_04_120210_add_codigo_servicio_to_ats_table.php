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
        Schema::table('ats', function (Blueprint $table) {
            $table->text('codigo_servicio')->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->foreignId('us_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ats', function (Blueprint $table) {
            $table->text('codigo_servicio')->nullable();
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->foreignId('us_id')->nullable()->constrained();
        });
    }
};
