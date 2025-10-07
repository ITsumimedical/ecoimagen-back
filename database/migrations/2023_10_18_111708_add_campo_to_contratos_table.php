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
        Schema::table('contrato_empleados', function (Blueprint $table) {
            $table->string('descripcion_obra_labor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contrato_empleados', function (Blueprint $table) {
            $table->string('descripcion_obra_labor')->nullable();
        });
    }
};
