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
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('afiliado_id')->nullable('afiliados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cobro_servicios', function (Blueprint $table) {
            $table->dropForeign('consulta_id');
            $table->dropColumn('consulta_id');
            $table->dropForeign('afiliado_id');
            $table->dropColumn('afiliado_id');
        });
    }
};
