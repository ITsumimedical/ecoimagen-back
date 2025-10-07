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
        Schema::create('codesumi_vias_administracion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codesumi_id')->constrained('codesumis')->onDelete('cascade');
            $table->foreignId('vias_administracion_id')->constrained('vias_administracion')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codesumi_vias_administracion');
    }
};
