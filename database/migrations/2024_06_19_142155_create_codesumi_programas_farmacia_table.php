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
        Schema::create('codesumi_programas_farmacia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codesumi_id')->constrained('codesumis');
            $table->foreignId('programas_farmacia_id')->constrained('programas_farmacias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codesumi_programas_farmacia');
    }
};
