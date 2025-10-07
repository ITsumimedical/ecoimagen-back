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
        Schema::table('antecedente_personales', function (Blueprint $table) {
            $table->foreignId('demanda_inducida_id')->nullable()->constrained('demanda_inducidas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedente_personales', function (Blueprint $table) {
            $table->foreignId('demanda_inducida_id')->nullable()->constrained('demanda_inducidas');
        });
    }
};
