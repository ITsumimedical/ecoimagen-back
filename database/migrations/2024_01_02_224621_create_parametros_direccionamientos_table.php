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
        Schema::create('parametros_direccionamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('direccionamiento_id')->constrained('direccionamientos');
            $table->foreignId('rep_id')->constrained('reps');
            $table->double('posicion');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametros_direccionamientos');
    }
};
