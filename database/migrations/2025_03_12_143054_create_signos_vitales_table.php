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
        Schema::create('signos_vitales', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha');
            $table->string('peso');
            $table->string('tension_arterial');
            $table->string('frecuencia_respiratoria');
            $table->string('frecuencia_cardiaca');
            $table->string('temperatura');
            $table->string('saturacion_oxigeno');
            $table->string('glucometria')->nullable();
            $table->string('tam')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('admision_urgencia_id')->constrained('admisiones_urgencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signos_vitales');
    }
};
