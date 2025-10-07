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
        Schema::create('canals', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_chat')->nullable();
            $table->foreignId('user_crea_id')->constrained('users');
            $table->foreignId('user_recibe_id')->nullable()->constrained('users');
            $table->foreignId('referencia_id')->nullable()->constrained('referencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canals');
    }
};
