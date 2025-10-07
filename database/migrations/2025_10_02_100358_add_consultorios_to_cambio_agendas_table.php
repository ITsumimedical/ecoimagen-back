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
        Schema::table('cambio_agendas', function (Blueprint $table) {
            $table->foreignId('consultorio_origen_id')->nullable()->constrained('consultorios')->after('accion');
            $table->foreignId('consultorio_destino_id')->nullable()->constrained('consultorios')->after('consultorio_origen_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cambio_agendas', function (Blueprint $table) {
            $table->dropForeign(['consultorio_origen_id']);
            $table->dropForeign(['consultorio_destino_id']);
            $table->dropColumn(['consultorio_origen_id', 'consultorio_destino_id']);
        });
    }
};
