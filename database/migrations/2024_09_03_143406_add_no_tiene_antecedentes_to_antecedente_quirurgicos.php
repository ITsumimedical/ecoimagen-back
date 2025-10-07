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
        Schema::table('antecedente_quirurgicos', function (Blueprint $table) {
            $table->string('no_tiene_antecedente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedente_quirurgicos', function (Blueprint $table) {
            $table->string('no_tiene_antecedente')->nullable();
        });
    }
};
