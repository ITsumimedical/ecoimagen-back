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
        Schema::table('registrofacturasumimedicals', function (Blueprint $table) {
            $table->foreignId('factura_detalle_id')->nullable()->constrained('factura_detalles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrofacturasumimedicals', function (Blueprint $table) {
            $table->dropForeign(['factura_detalle_id']);
            $table->dropColumn('factura_detalle_id');
        });
    }
};
