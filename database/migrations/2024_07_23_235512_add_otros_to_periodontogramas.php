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
        Schema::table('periodontogramas', function (Blueprint $table) {
            $table->string('requiere_endodoncia')->nullable();
            $table->string('requiere_sellante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periodontogramas', function (Blueprint $table) {
            $table->string('requiere_endodoncia')->nullable();
            $table->string('requiere_sellante')->nullable();
        });
    }
};
