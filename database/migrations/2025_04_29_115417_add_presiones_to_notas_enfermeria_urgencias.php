<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notas_enfermeria_urgencias', function (Blueprint $table) {
            $table->decimal('presion_sistolica', 8, 2)->nullable();
            $table->decimal('presion_diastolica', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notas_enfermeria_urgencias', function (Blueprint $table) {
            $table->dropColumn([
                'presion_diastolica',
                'presion_sistolica',
            ]);
        });
    }
};
