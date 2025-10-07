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
        Schema::create('video_tipo_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained('videos');
            $table->foreignId('tipo_usuario_id')->constrained('tipo_usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_tipo_usuarios');
    }
};
