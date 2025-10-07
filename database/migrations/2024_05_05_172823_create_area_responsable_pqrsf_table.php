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
        Schema::create('area_responsable_pqrsf', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsable_pqrsf_id')->constrained('responsable_pqrsfs');
            $table->foreignId('area_responsable_pqrsf_id')->constrained('area_responsable_pqrsf_responsable_pqrsf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_responsable_pqrsf');
    }
};
