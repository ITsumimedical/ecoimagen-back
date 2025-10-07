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
        Schema::create('cuestionario_g_a_d_2_s', function (Blueprint $table) {
            $table->id();
            $table->string('sentirse_nervioso_ansioso');
            $table->string('no_poder_controlar_preocupacion');
            $table->string('interpretacion_resultado');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuestionario_g_a_d_2_s');
    }
};
