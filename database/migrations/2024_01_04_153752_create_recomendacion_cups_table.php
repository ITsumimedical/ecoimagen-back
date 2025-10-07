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
        Schema::create('recomendacion_cups', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->foreignId('usuario_realiza_id')->constrained('users');
            $table->boolean('estado')->default(true);
            $table->foreignId('cup_id')->constrained('cups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recomendacion_cups');
    }
};
