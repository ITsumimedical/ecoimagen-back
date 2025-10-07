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
        Schema::create('adjunto_sarlafts', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('ruta')->nullable();
            $table->foreignId('sarlaft_id')->nullable()->constrained('sarlafts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjunto_sarlafts');
    }
};
