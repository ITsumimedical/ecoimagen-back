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
        Schema::create('direccionamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('georeferenciacion_id')->constrained('georeferenciacions');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('rep_id')->constrained('reps');
            $table->boolean('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcionamientos');
    }
};
