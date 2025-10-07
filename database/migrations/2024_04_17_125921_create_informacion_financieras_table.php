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
        Schema::create('informacion_financieras', function (Blueprint $table) {
            $table->id();
            $table->string('total_activos')->nullable();
            $table->string('total_pasivos')->nullable();
            $table->string('ingreso_mensual')->nullable();
            $table->string('otros_ingresos')->nullable();
            $table->string('concepto_ingreso')->nullable();
            $table->string('egresos_mensuales')->nullable();
            $table->string('otros_egresos')->nullable();
            $table->string('concepto_egreso')->nullable();
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('sarlaft_id')->nullable()->constrained('sarlafts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_financieras');
    }
};
