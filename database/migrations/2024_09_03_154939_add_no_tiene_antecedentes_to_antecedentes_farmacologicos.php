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
        Schema::table('antecedentes_farmacologicos', function (Blueprint $table) {
            $table->string('no_tiene_antecedentes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedentes_farmacologicos', function (Blueprint $table) {
            $table->string('no_tiene_antecedentes')->nullable();
        });
    }
};
