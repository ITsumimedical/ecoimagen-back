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
        Schema::create('respuesta_sivigilas', function (Blueprint $table) {
            $table->id();
            $table->string('respuesta_campo')->nullable();
            $table->foreignId('campo_id')->nullable()->constrained('campo_sivigilas');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('pais_id')->nullable()->constrained('paises');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos');
            $table->foreignId('municipio_id')->nullable()->constrained('municipios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuesta_sivigilas');
    }
};
