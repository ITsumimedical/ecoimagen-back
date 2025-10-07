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
        Schema::create('gestion_orden_prestador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_procedimiento_id')->nullable()->constrained('orden_procedimientos');
            $table->foreignId('orden_codigo_propio_id')->nullable()->constrained('orden_codigo_propios');
            $table->foreignId('estado_gestion_id')->nullable()->constrained('estados');
            $table->text('observacion')->nullable();
            $table->string('funcionario_responsable',100)->nullable();
            $table->foreignId('funcionario_gestiona')->nullable()->constrained('users');
            $table->date('fecha_cancelacion')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->text('causa_cancelacion')->nullable();
            $table->date('fecha_sugerida')->nullable();
            $table->date('fecha_solicita_afiliado')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->string('cirujano',100)->nullable();
            $table->string('especialidad',100)->nullable();
            $table->date('fecha_preanestesia')->nullable();
            $table->date('fecha_cirugia')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_orden_prestador');
    }
};
