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
        Schema::create('actuacion_tutelas_cup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_id')->constrained('cups');
            $table->foreignId('actuacion_tutelas_id')->constrained('actuacion_tutelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actuacion_tutelas_cup');
    }
};
