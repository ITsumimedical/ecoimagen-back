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
        Schema::create('cambios_concurrencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingreso_concurrencia_id')->nullable()->constrained('ingreso_concurrencias');
            $table->foreignId('concurrencia_id')->nullable()->constrained('concurrencias');
            $table->foreignId('user_id')->constrained('users');
            $table->text('actualizacion');
            $table->date('fecha_aplicacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cambios_concurrencias');
    }
};
