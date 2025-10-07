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
        Schema::create('servicios_pqrsf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_id')->constrained('cups');
            $table->foreignId('formulario_pqrsf_id')->constrained('formulariopqrsfs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_pqrsf');
    }
};
