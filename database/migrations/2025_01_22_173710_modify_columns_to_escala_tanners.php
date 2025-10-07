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
        Schema::table('escala_tanners', function (Blueprint $table) {
            $table->string('mamario_mujeres')->nullable()->change();
            $table->string('pubiano_mujeres')->nullable()->change();
            $table->string('genital_hombres')->nullable()->change();
            $table->string('pubiano_hombres')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escala_tanners', function (Blueprint $table) {
            $table->string('mamario_mujeres')->nullable(false)->change();
            $table->string('pubiano_mujeres')->nullable(false)->change();
            $table->string('genital_hombres')->nullable(false)->change();
            $table->string('pubiano_hombres')->nullable(false)->change();
        });
    }

};
