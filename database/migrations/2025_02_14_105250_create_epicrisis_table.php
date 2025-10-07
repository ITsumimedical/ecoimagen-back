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
        Schema::create('epicrisis', function (Blueprint $table) {
            $table->id();
            $table->string('motivo_salida');
            $table->string('estado_salida');
            $table->timestamp('fecha_deceso')->nullable();
            $table->string('certificado_defuncion')->nullable();
            $table->string('causa_muerte')->nullable();
            $table->timestamp('fecha_egreso');
            $table->string('orden_alta');
            $table->text('observacion');
            $table->timestamp('fecha_referencia')->nullable();
            $table->text('objeto_remision')->nullable();
            $table->string('servicio_remision')->nullable();
            $table->string('otro_servicio')->nullable();
            $table->string('medio_referencia')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->foreignId('admision_urgencia_id')->constrained('admisiones_urgencias');
            $table->foreignId('entidad_id')->nullable()->constrained('entidades');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epicrisis');
    }
};
