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
        Schema::create('familia_tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tarifa_id')->nullable()->constrained('tarifas');
            $table->foreignId('familia_id')->nullable()->constrained('familias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familia_tarifas');
    }
};
