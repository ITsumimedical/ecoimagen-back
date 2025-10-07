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
        Schema::create('agendamiento_cirugias', function (Blueprint $table) {
            $table->id();
            $table->string('clase');
            $table->date('fecha');
            $table->time('hora_inicio_estimada');
            $table->integer('duracion')->nullable();
            $table->time('hora_finalizacion')->nullable();
            $table->string('color_evento');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('cup_id')->nullable()->constrained('cups');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('reps_id')->nullable()->constrained('reps');
            $table->foreignId('consultorio_id')->constrained('consultorios');
            $table->foreignId('usuario_crea')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamiento_cirugias');
    }
};
