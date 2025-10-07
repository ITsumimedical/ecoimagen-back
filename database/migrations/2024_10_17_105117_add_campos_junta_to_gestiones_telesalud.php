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
        Schema::table('gestiones_telesaluds', function (Blueprint $table) {
            $table->foreignId('institucion_prestadora_id')->nullable()->constrained('reps');
            $table->foreignId('eapb_id')->nullable()->constrained('reps');
            $table->text('evaluacion_junta')->nullable();
            $table->string('junta_aprueba')->nullable();
            $table->string('clasificacion_prioridad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gestiones_telesaluds', function (Blueprint $table) {
            $table->dropForeign(['institucion_prestadora_id']);
            $table->dropForeign(['eapb_id']);
            $table->dropColumn(['institucion_prestadora_id', 'eapb_id', 'evaluacion_junta', 'junta_aprueba', 'clasificacion_prioridad']);
        });
    }
};
