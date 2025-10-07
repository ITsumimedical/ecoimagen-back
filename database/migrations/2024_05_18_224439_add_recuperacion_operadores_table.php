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
        Schema::table('operadores', function (Blueprint $table) {
            $table->string('email_recuperacion')->nullable();
            $table->string('telefono_recuperacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operadores', function (Blueprint $table) {
            $table->string('email_recuperacion')->nullable();
            $table->string('telefono_recuperacion')->nullable();
        });
    }
};
