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
        Schema::table('cuestionario_g_a_d_2_s', function (Blueprint $table) {
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuestionario_g_a_d_2_s', function (Blueprint $table) {
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
        });
    }
};
