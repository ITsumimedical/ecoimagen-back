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
        Schema::create('estratificacion_findrisks', function (Blueprint $table) {
            $table->id();
            $table->integer('edad_puntaje')->nullable();
            $table->integer('indice_corporal')->nullable();
            $table->integer('perimetro_abdominal')->nullable();
            $table->text('actividad_fisica')->nullable();
            $table->integer('puntaje_fisica')->nullable();
            $table->integer('frutas_verduras')->nullable();
            $table->text('hipertension')->nullable();
            $table->integer('resultado_hipertension')->nullable();
            $table->text('glucosa')->nullable();
            $table->integer('resultado_glucosa')->nullable();
            $table->text('diabetes')->nullable();
            $table->text('parentezco')->nullable();
            $table->integer('resultado_diabetes')->nullable();
            $table->integer('totales')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estratificacion_findrisks');
    }
};
