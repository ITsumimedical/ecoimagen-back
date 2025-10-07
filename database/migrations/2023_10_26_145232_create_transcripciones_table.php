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
        Schema::create('transcripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->string('ambito');
            $table->string('medico_ordeno')->nullable();
            $table->string('finalidad');
            $table->string('tipo_transcripcion');
            $table->text('observaciones')->nullable();
            $table->foreignId('prestador_id')->nullable()->constrained('prestadores');
            $table->foreignId('sede_id')->nullable()->constrained('sedes');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transcripciones');
    }
};
