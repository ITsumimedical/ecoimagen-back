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
        Schema::table('mesa_ayudas', function (Blueprint $table) {
            $table->float('calficacion')->nullable();
            $table->timestamp('tiempo_respuesta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mesa_ayudas', function (Blueprint $table) {
            $table->float('calficacion')->nullable();
            $table->timestamp('tiempo_respuesta')->nullable();
        });
    }
};
