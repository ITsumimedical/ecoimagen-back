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
        Schema::create('asignados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_responsable_id')->constrained('area_responsable_pqrsf_responsable_pqrsf');
            $table->foreignId('formulario_pqrsf_id')->constrained('formulariopqrsfs');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignados');
    }
};
