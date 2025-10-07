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
        Schema::table('cobro_servicios', function (Blueprint $table) {
            $table->foreignId('cobro_factura_id')->nullable()->constrained('cobro_facturas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cobro_servicios', function (Blueprint $table) {
            $table->dropForeign(['cobro_factura_id']);
            $table->dropColumn('cobro_factura_id');
        });
    }
};
