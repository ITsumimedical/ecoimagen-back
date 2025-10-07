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
        Schema::table('demanda_inducidas', function (Blueprint $table) {
            $table->date('fecha_registro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demanda_inducidas', function (Blueprint $table) {
            $table->date('fecha_registro')->nullable();
        });
    }
};
