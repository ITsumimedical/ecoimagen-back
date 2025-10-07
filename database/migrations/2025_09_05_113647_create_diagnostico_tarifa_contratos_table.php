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
        Schema::create('diagnostico_tarifa_contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarifa_id')->nullable()->constrained('tarifas');
            $table->foreignId('cie10_id')->nullable()->constrained('cie10s');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostico_tarifa_contratos');
    }
};
