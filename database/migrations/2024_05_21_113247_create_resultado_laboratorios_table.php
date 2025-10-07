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
        Schema::create('resultado_laboratorios', function (Blueprint $table) {
            $table->id();
            $table->string('laboratorio');
            $table->string('resultado_lab')->nullable();
            $table->string('factor_rh')->nullable();
            $table->string('fecha_laboratorio');
            $table->string('adjunto')->nullable();
            $table->foreignId('medico_registra')->constrained('users');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_laboratorios');
    }
};
