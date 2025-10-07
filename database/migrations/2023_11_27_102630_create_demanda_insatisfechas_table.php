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
        Schema::create('demanda_insatisfechas', function (Blueprint $table) {
            $table->id();
            $table->text('observacion')->nullable();
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->foreignId('cita_id')->constrained('citas');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demanda_insatisfechas');
    }
};
