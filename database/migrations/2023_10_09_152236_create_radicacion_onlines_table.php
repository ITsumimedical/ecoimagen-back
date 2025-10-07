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
        Schema::create('radicacion_onlines', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->text('descripcion');
            $table->foreignId('tipo_solicitud_red_vital_id')->nullable()->constrained('tipo_solicitud_red_vitals');
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radicacion_onlines');
    }
};
