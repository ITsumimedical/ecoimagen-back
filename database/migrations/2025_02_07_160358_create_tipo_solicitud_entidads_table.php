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
        Schema::create('tipo_solicitud_entidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_solicitud_id')->constrained('tipo_solicitud_red_vitals');
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_solicitud_entidads');
    }
};
