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
        Schema::create('registros_actualizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('registros_actualizados_reactivados')->nullable();
            $table->string('registros_actualizados_retirados')->nullable();
            $table->string('registros_actualizados_proteccion_laboral_cot')->nullable();
            $table->string('registros_actualizados_proteccion_laboral_ben')->nullable();
            $table->string('registros_insertados')->nullable();
            $table->text('registros_actualizados_entidad_existente')->nullable();
            $table->text('identificacion_usuarios_entidad_existente')->nullable();
            $table->string('registros_actualizados_cambio_tipo_documento')->nullable();
            $table->string('registros_actualizados_cambio_tipo_afiliado')->nullable();
            $table->string('registros_actualizados_fecha_nacimiento')->nullable();
            $table->string('registros_actualizados_sexo')->nullable();
            $table->string('registros_actualizados_no_registra_bd')->nullable();
            $table->dateTime('fecha_ejecucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_actualizaciones');
    }
};
