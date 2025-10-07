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
        Schema::create('historia_clinica_nota_aclaratoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_aclaratoria_id')->nullable()->constrained('nota_aclaratorias');
            $table->foreignId('historia_clinica_id')->nullable()->constrained('historias_clinicas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_clinica_nota_aclaratoria');
    }
};
