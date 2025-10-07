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
        Schema::create('log_registro_rips_sumi', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_http_respuesta');
            $table->text('mensaje_http_respuesta');
            $table->foreignId('user_id')->constrained('users');
            $table->json('payload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_registro_rips_sumi');
    }
};
