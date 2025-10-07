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
        Schema::table('respuesta_sivigilas', function (Blueprint $table) {
            $table->foreignId('registro_id')->nullable()->constrained('registro_sivigilas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('respuesta_sivigilas', function (Blueprint $table) {
            $table->dropForeign(['registro_id']);
            $table->dropColumn('registro_id');
        });
    }
};
