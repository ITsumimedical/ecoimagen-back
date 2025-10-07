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
        Schema::create('codigo_propio_pqrsfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codigo_propio_id')->constrained('codigo_propios');
            $table->foreignId('formulariopqrsf_id')->constrained('formulariopqrsfs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigo_propio_pqrsfs');
    }
};
