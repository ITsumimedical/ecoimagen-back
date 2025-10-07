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
        Schema::table('detalle_movimientos', function (Blueprint $table) {
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_movimientos', function (Blueprint $table) {
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
        });
    }
};
