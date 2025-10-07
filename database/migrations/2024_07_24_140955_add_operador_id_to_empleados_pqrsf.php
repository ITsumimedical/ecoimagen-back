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
        Schema::table('empleados_pqrsf', function (Blueprint $table) {
            $table->foreignId('operador_id')->nullable()->constrained('operadores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empleados_pqrsf', function (Blueprint $table) {
            $table->foreignId('operador_id')->nullable()->constrained('operadores');
        });
    }
};
