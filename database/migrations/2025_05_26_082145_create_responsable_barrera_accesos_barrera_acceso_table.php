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
        Schema::create('responsable_barrera_accesos_barrera_acceso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsable_barrera_accesos_id')->constrained('responsable_barrera_accesos');
            $table->foreignId('barrera_acceso_id')->constrained('barrera_accesos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsable_barrera_accesos_barrera_acceso');
    }
};
