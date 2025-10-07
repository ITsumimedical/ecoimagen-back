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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->text('hallazgos_clinicos')->nullable();
            $table->text('hallazgos_radiograficos')->nullable();
            $table->text('procedimiento_realizado_odontologia')->nullable();
            $table->boolean('paciente_controlado_odontologia')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('hallazgos_clinicos');
            $table->dropColumn('hallazgos_radiograficos');
            $table->dropColumn('procedimiento_realizado_odontologia');
            $table->dropColumn('paciente_controlado_odontologia');
        });
    }
};
