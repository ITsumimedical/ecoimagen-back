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
        Schema::table('consentimientos_informados', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->string('version')->nullable();
            $table->string('fecha_aprobacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consentimientos_informados', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->string('version')->nullable();
            $table->string('fecha_aprobacion')->nullable();
        });
    }
};
