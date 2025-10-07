<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTeleapoyosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teleapoyos', function (Blueprint $table) {
            $table->id();
            $table->SoftDeletes();
            $table->string('motivo_teleorientacion',2500);
            $table->string('resumen_historia_clinica',2500);
            $table->string('respuesta',2500)->nullable();
            $table->string('pertinente')->nullable();
            $table->boolean('girs')->default(false);
            $table->text('observacion_reasignacion_girs')->nullable();
            $table->boolean('teleconcepto_pertinente')->nullable();
            $table->text('observacion_teleconcepto_pertinente')->nullable();
            $table->boolean('ordenamiento_pertinente')->nullable();
            $table->text('observacion_pertinente_ordenamiento')->nullable();
            $table->string('institucion_prestadora')->nullable();
            $table->string('eapb')->nullable();
            $table->text('evaluacion_junta',)->nullable();
            $table->string('junta_aprueba',2500)->nullable();
            $table->boolean('girs_auditor')->nullable();
            $table->string('pertinencia_prioridad',2500)->nullable();
            $table->string('pertinencia_evaluacion',2500)->nullable();
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('tipo_solicitudes_id')->constrained('tipo_solicitudes');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('user_crea_id')->constrained('users');
            $table->foreignId('user_responde_id')->nullable()->constrained('users');
            $table->foreignId('especialidad_id')->constrained('especialidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teleapoyos');
    }
}
