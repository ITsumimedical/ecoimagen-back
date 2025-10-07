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
        Schema::table('cargue_historia_contingencias', function (Blueprint $table) {
            $table->foreignId('funcionario_carga')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargue_historia_contingencias', function (Blueprint $table) {
            $table->dropColumn('funcionario_carga');
        });
    }
};
