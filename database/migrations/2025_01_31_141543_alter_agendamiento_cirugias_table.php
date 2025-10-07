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
        Schema::table('agendamiento_cirugias', function (Blueprint $table) {
            $table->time('hora_fin_estimada');
            $table->foreignId('anestesiologo')->constrained('users');
            $table->string('tipo_anestesia');
            $table->date('fecha_aval_cirugia');
            $table->boolean('aval_cirugia')->default(false);
            $table->foreignId('cirujano')->constrained('users');
            $table->string('especialidad_cirujamo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamiento_cirugias', function (Blueprint $table) {
            $table->time('hora_fin_estimada');
            $table->foreignId('anestesiologo')->nullable()->constrained('users');
            $table->string('tipo_anestesia');
            $table->date('fecha_aval_cirugia')->nullable();
            $table->boolean('aval_cirugia')->default(false);
            $table->foreignId('cirujano')->constrained('users');
            $table->string('especialidad_cirujano');
            $table->text('observacion_negacion_aval_cirugia')->nullable();
        });
    }
};
