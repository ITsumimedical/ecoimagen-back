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
        Schema::create('orden_codigo_propios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->foreignId('codigo_propio_id')->constrained('codigo_propios');
            $table->foreignId('rep_id')->nullable()->constrained('reps');
            $table->foreignId('estado_id')->constrained('estados');
            $table->integer('cantidad');
            $table->integer('valor_tarifa')->nullable();
            $table->date('fecha_vigencia');
            $table->text('observacion')->nullable();
            $table->boolean('autorizacion')->nullable();
            $table->boolean('anexo3')->nullable();
            $table->date('fecha_solicitada')->nullable();
            $table->date('fecha_sugerida')->nullable();
            $table->date('fecha_cancelacion')->nullable();
            $table->text('cancelacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('responsable')->nullable();
            $table->text('motivo')->nullable();
            $table->text('causa')->nullable();
            $table->text('soportes')->nullable();
            $table->boolean('atendida')->nullable();
            $table->text('cirujano')->nullable();
            $table->text('especialidad')->nullable();
            $table->date('fecha_preanestesia')->nullable();
            $table->date('fecha_cirugia')->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->date('fecha_resultado')->nullable();
            $table->date('fecha_orden')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_codigo_propios');
    }
};
