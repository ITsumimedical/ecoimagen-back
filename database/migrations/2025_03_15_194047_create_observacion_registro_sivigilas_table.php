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
        Schema::create('observacion_registro_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->text('observacion')->nullable();
            $table->string('email_medico')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('registro_id')->constrained('registro_sivigilas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observacion_registro_sivigilas');
    }
};
