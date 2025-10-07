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
        Schema::table('operadores', function (Blueprint $table) {
            $table->foreignId('cargo_id')->nullable()->constrained('cargos');
            $table->foreignId('especialidad_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operadores', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropColumn(['cargo_id']);
            
            // Aquí restauras el campo `especialidad_id` a su estado original si no era nullable originalmente
            $table->foreignId('especialidad_id')->nullable(false)->change();
        });
    }
};
