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
        Schema::table('antecedente_personales', function (Blueprint $table) {
            $table->foreignId('consulta_1_demanda')->nullable()->constrained('consultas');
            $table->foreignId('consulta_2_demanda')->nullable()->constrained('consultas');
            $table->foreignId('consulta_3_demanda')->nullable()->constrained('consultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedente_personales', function (Blueprint $table) {
            $table->foreignId('consulta_1_demanda')->nullable()->constrained('consultas');
            $table->foreignId('consulta_2_demanda')->nullable()->constrained('consultas');
            $table->foreignId('consulta_3_demanda')->nullable()->constrained('consultas');
        });
    }
};
