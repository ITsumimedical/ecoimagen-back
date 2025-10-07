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
        Schema::create('cie10_afiliados', function (Blueprint $table) {
            $table->id();
            $table->boolean('esprimario')->nullable();
            $table->string('tipo_diagnostico')->nullable();
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('cie10_id')->nullable()->constrained('cie10s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cie10_afiliados');
    }
};
