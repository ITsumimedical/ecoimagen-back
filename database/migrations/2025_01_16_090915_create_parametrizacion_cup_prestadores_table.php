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
        Schema::create('parametrizacion_cup_prestadores', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('cup_id')->nullable()->constrained('cups');
            $table->foreignId('codigo_propio_id')->nullable()->constrained('codigo_propios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametrizacion_cup_prestadores');
    }
};
