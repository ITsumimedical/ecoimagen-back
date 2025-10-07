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
        Schema::create('notas_enfermerias', function (Blueprint $table) {
            $table->id();
            $table->text('nota');
            $table->text('signos_alarma')->nullable();
            $table->text('cuidados_casa')->nullable();
            $table->text('caso_urgencias')->nullable();
            $table->text('alimentacion')->nullable();
            $table->text('efectos_secundarios')->nullable();
            $table->text('habito_higiene')->nullable();
            $table->text('derechos_deberes')->nullable();
            $table->text('normas_sala_quimioterapia')->nullable();
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_enfermerias');
    }
};
