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
        Schema::create('parametros_salario_minimos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salario_minimo_id')->constrained('salario_minimos');
            $table->string('rango')->nullable();
            $table->string('valorCuota')->nullable();
            $table->string('valorCopagos')->nullable();
            $table->string('valorEvento')->nullable();
            $table->string('valorCuotaAnual')->nullable();
            $table->string('valorCopagosAnual')->nullable();
            $table->string('valorEventoAnual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros_salario_minimos');
    }
};
