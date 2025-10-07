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
        Schema::create('caracterizacion_cancer_propio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caracterizacion_id')->constrained('caracterizacion_afiliados');
            $table->foreignId('tipo_cancer_id')->constrained('tipo_cancer_caracterizacions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracterizacion_cancer_propio');
    }
};
