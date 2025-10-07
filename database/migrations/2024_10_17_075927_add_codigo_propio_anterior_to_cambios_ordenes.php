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
        Schema::table('cambios_ordenes', function (Blueprint $table) {
            $table->foreignId('codigo_propio_anterior_id')->nullable()->constrained('codigo_propios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cambios_ordenes', function (Blueprint $table) {
            $table->foreignId('codigo_propio_anterior_id')->nullable()->constrained('codigo_propios');
        });
    }
};
