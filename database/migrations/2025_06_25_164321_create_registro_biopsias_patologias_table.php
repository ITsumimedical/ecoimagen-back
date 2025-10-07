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
        Schema::create('registro_biopsias_patologias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->timestamp('fecha_inicial_biopsia')->nullable();
            $table->timestamp('fecha_final_biopsia')->nullable();
            $table->string('lateralidad')->nullable();
            $table->timestamp('fecha_inicio_patologia')->nullable();
            $table->timestamp('fecha_final_patologia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_biopsias_patologias');
    }
};
