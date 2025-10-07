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
            $table->foreignId('finalidad_id')->nullable()->constrained('finalidad_consultas');
            $table->foreignId('causa_consulta_externa_id')->nullable()->constrained('consulta_causa_externas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->foreignId('finalidad_id')->nullable()->constrained('finalidad_consultas');
            $table->foreignId('causa_consulta_externa_id')->nullable()->constrained('consulta_causa_externas');
        });
    }
};
