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
        Schema::create('antecedente_ecomapas', function (Blueprint $table) {
            $table->id();
            $table->string('asiste_colegio')->nullable();
            $table->string('comparte_amigos')->nullable();
            $table->string('comparte_vecinos')->nullable();
            $table->string('pertenece_club_deportivo')->nullable();
            $table->string('pertenece_club_social_cultural')->nullable();
            $table->string('asiste_iglesia')->nullable();
            $table->string('trabaja')->nullable();
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
        Schema::dropIfExists('antecedentes_ecomapas');
    }
};
