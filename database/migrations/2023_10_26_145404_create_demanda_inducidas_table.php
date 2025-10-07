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
        Schema::create('demanda_inducidas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_demanda_inducida');
            $table->string('programa_remitido');
            $table->date('fecha_dx_riesgo_cardiovascular')->nullable();
            $table->string('descripcion_evento_salud_publica')->nullable();
            $table->string('descripcion_otro_programa')->nullable();
            $table->text('observaciones');
            $table->boolean('demanda_inducida_efectiva')->default(0);
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->foreignId('consulta_1_id')->nullable()->constrained('consultas');
            $table->foreignId('consulta_2_id')->nullable()->constrained('consultas');
            $table->foreignId('consulta_3_id')->nullable()->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demanda_inducidas');
    }
};
