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
            $table->foreignId('tipo_barrera_acceso_id')->nullable()->constrained('barrera_accesos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barrera_accesos', function (Blueprint $table) {
             $table->dropForeign(['tipo_barrera_acceso_id']);
            $table->dropColumn('tipo_barrera_acceso_id');
        });
    }
};
