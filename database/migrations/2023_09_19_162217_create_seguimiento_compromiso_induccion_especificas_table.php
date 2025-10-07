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
        Schema::create('seguimiento_compromiso_induccion_especificas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compromiso_induccion_especifica_id')->constrained('compromiso_induccion_especificas');
            $table->foreignId('estado_id')->constrained('estados');
            $table->text('nota_adicional')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_compromiso_induccion_especificas');
    }
};
