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
        Schema::create('referencias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_anexo');
            $table->string('especialidad_remision');
            $table->string('tipo_solicitud')->nullable();
            $table->string('codigo_remision')->nullable();
            $table->text('descripcion')->nullable();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencias');
    }
};
