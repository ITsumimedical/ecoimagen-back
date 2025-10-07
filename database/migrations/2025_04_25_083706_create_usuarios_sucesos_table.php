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
        Schema::create('usuarios_sucesos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suceso_id')->nullable()->constrained('sucesos');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('usuario_defecto')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_sucesos');
    }
};
