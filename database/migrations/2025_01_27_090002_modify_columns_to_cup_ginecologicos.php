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
        Schema::table('cup_ginecologicos', function (Blueprint $table) {
            $table->string('estado_ginecologia')->nullable()->change();
            $table->string('descripcion_citologia')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cup_ginecologicos', function (Blueprint $table) {
            $table->string('estado_ginecologia')->nullable(false)->change();
            $table->string('descripcion_citologia')->nullable(false)->change();
        });
    }
};
