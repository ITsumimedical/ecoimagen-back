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
        Schema::table('barrera_accesos', function (Blueprint $table) {
            $table->text('observacion_solucion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barrera_accesos', function (Blueprint $table) {
            $table->dropColumn('observacion_solucion');
        });
    }
};
