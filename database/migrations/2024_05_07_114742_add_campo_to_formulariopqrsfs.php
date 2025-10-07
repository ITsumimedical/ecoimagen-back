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
        Schema::table('formulariopqrsfs', function (Blueprint $table) {
            $table->string('codigo_super')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formulariopqrsfs', function (Blueprint $table) {
            $table->string('codigo_super')->nullable();
        });
    }
};
