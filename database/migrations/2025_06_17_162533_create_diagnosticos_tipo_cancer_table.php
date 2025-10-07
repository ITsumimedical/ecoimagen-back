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
        Schema::create('diagnosticos_tipo_cancer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_cancer_id')->constrained('tipo_cancers');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos_tipo_cancer');
    }
};
