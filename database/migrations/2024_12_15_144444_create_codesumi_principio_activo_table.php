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
        Schema::create('codesumi_principio_activo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codesumi_id')->constrained('codesumis');
            $table->foreignId('principio_activo_id')->constrained('principio_activos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codesumi_principio_activo');
    }
};
