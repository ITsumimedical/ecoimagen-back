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
        Schema::table('cup_mamografias', function (Blueprint $table) {
            $table->string('estado_mamografia')->nullable()->change();
            $table->string('descripcion_mamografia')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cup_mamografias', function (Blueprint $table) {
            $table->string('estado_mamografia')->nullable(false)->change();
            $table->string('descripcion_mamografia')->nullable(false)->change();
        });
    }
};
