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
        Schema::create('dientes_orden_procedimientos', function (Blueprint $table) {
            $table->id();
            $table->integer('diente')->nullable();
            $table->date('fecha')->nullable();
            $table->foreignId('orden_procedimiento_id')->constrained('orden_procedimientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dientes_orden_procedimientos');
    }
};
