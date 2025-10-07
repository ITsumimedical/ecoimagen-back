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
        Schema::table('caracterizacion_afiliados', function (Blueprint $table) {
            $table->text('estratificacion_riesgo')->nullable();
            $table->text('grupo_riesgo')->nullable();
            $table->foreignId('user_gestor_id')->nullable()->constrained('users');
            $table->foreignId('user_enfermeria_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caracterizacion_afiliados', function (Blueprint $table) {
            $table->dropColumn('estratificacion_riesgo');
            $table->dropColumn('grupo_riesgo');
            $table->dropForeign('user_gestor_id');
            $table->dropColumn('user_gestor_id');
            $table->dropForeign('user_enfermeria_id');
            $table->dropColumn('user_enfermeria_id');
        });
    }
};
