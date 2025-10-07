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
        Schema::table('orden_codigo_propios', function (Blueprint $table) {
            $table->foreignId('estado_id_gestion_prestador')->nullable()->constrained('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_codigo_propios', function (Blueprint $table) {
            $table->dropForeign(['estado_id_gestion_prestador']);
            $table->dropColumn('estado_id_gestion_prestador');
        });
    }
};
