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
        Schema::table('auditorias', function (Blueprint $table) {
            $table->text('fundamento_legal')->nullable();
            $table->text('alternativas_acceso_salud')->nullable();
            $table->text('tipo_plan_usuario')->nullable();
            $table->text('firma_electronica')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auditorias', function (Blueprint $table) {
            $table->dropColumn('fundamento_legal');
            $table->dropColumn('alternativas_acceso_salud');
            $table->dropColumn('tipo_plan_usuario');
            $table->dropColumn('firma_electronica');
        });
    }
};
