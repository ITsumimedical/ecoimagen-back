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
        Schema::create('organos_fonoarticulatorios', function (Blueprint $table) {
            $table->id();
            $table->string('lengua')->nullable();
            $table->string('paladar')->nullable();
            $table->string('labios')->nullable();
            $table->string('mucosa')->nullable();
            $table->string('amigdalas_palatinas')->nullable();
            $table->string('tono')->nullable();
            $table->string('timbre')->nullable();
            $table->string('volumen')->nullable();
            $table->string('modo_respiratorio')->nullable();
            $table->string('tipo_respiratorio')->nullable();
            $table->string('evaluacion_postural')->nullable();
            $table->string('rendimiento_vocal')->nullable();
            $table->string('prueba_de_glatzel')->nullable();
            $table->string('golpe_glotico')->nullable();
            $table->string('conducto_auditivo_externo')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organos_fonoarticulatorios');
    }
};
