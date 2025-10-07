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
        Schema::create('orden_concurrencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_id')->constrained('cups');
            $table->integer('costo')->nullable();
            $table->integer('cantidad');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('ingreso_concurrencia_id')->constrained('ingreso_concurrencias');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_concurrencias');
    }
};
