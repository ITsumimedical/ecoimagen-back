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
        Schema::create('logos_reps_historias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_logo');
			$table->string('ruta');
			$table->foreignId('rep_id')->constrained('reps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logos_reps_historias');
    }
};
