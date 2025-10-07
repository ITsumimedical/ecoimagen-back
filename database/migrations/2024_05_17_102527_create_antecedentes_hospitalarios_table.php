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
        Schema::create('antecedentes_hospitalarios', function (Blueprint $table) {
            $table->id();
            $table->string('hospitalizacion_neonatal', 2000)->nullable();
            $table->string('descripcion_neonatal', 2000)->nullable();
            $table->string('consulta_urgencias', 2000)->nullable();
            $table->string('descripcion_urgencias', 2000)->nullable();
            $table->string('hospitalizacion_ultimo_anio', 2000)->nullable();
            $table->string('descripcion_hospiurg', 2000)->nullable();
            $table->string('mas_tres_hospitalizaciones_anio', 2000)->nullable();
            $table->string('descripcion_urgencias_mas_tres', 2000)->nullable();
            $table->string('hospitalizacion_mayor_dos_semanas_anio', 2000)->nullable();
            $table->string('descripcion_urgencias_mas_tres_semanas', 2000)->nullable();
            $table->string('hospitalizacion_uci_anio', 2000)->nullable();
            $table->string('descripcion_hospi_uci', 2000)->nullable();
            $table->foreignId('medico_registra')->constrained('users');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedentes_hospitalarios');
    }
};
