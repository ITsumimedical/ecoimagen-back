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
        Schema::table('evento_adversos', function (Blueprint $table) {
            $table->string('fabricante_dispositivo')->nullable();
            $table->string('fabricante_biomedico')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evento_adversos', function (Blueprint $table) {
            $table->dropForeign('fabricante_dispositivo')->nullable();
            $table->dropForeign('fabricante_biomedico')->nullable();
        });
    }
};
