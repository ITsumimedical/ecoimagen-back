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
        Schema::create('exclusion_actuacion_tutela', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actuacion_tutela_id')->constrained('actuacion_tutelas');
            $table->foreignId('user_id')->constrained('users');
            $table->string('exclusion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exclusion_actuacion_tutela');
    }
};
