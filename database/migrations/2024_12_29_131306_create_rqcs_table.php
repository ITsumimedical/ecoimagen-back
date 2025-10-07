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
        Schema::create('rqcs', function (Blueprint $table) {
            $table->id();
            $table->boolean('lenguaje_normal');
            $table->boolean('duerme_mal');
            $table->boolean('tenido_convulsiones');
            $table->boolean('dolores_cabeza');
            $table->boolean('huido_casa');
            $table->boolean('robado_casa');
            $table->boolean('nervioso');
            $table->boolean('lento_responder');
            $table->boolean('no_juega_amigos');
            $table->boolean('orina_defeca');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rqcs');
    }
};
