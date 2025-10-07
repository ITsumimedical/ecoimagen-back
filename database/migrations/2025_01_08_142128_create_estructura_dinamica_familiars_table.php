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
        Schema::create('estructura_dinamica_familiars', function (Blueprint $table) {
            $table->id();
            $table->text('estructura_dinamica');
            $table->text('situacion_socioeconomica');
            $table->text('entorno_social');
            $table->text('riesgo_psicosocial');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estructura_dinamica_familiars');
    }
};
