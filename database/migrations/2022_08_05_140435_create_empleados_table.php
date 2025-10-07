<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('documento')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('genero')->nullable();
            $table->string('identidad_genero')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->date('fecha_expedicion_documento')->nullable();
            $table->string('rh')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('grupo_etnico')->nullable();
            $table->boolean('cabeza_hogar')->nullable()->default(false);
            $table->float('peso')->nullable();
            $table->float('altura')->nullable();
            $table->string('direccion_residencia')->nullable();
            $table->string('barrio')->nullable();
            $table->string('area_residencia')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('celular2')->nullable();
            $table->string('email_personal')->nullable();
            $table->string('email_corporativo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('nivel_estudio')->nullable();
            $table->boolean('victima')->nullable()->default(false);
            $table->boolean('discapacidad')->nullable()->default(false);
            $table->string('descripcion_discapacidad')->nullable();
            $table->string('ajuste_puesto')->nullable();
            $table->float('edad')->nullable();
            $table->float('indice_masa_corporal')->nullable();
            $table->boolean('medico')->nullable()->default(false);
            $table->string('registro_medico')->nullable();
            // relaciones
            $table->foreignId('tipo_documento_id')->nullable()->constrained('tipo_documentos');
            $table->foreignId('orientacion_sexual_id')->nullable()->constrained('orientacion_sexuals');
            $table->foreignId('municipio_expedicion_id')->nullable()->constrained('municipios');
            $table->foreignId('municipio_nacimiento_id')->nullable()->constrained('municipios');
            $table->foreignId('municipio_residencia_id')->nullable()->constrained('municipios');
            $table->foreignId('areath_id')->nullable()->constrained('area_ths');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('sede_id')->nullable()->constrained('sedes');
            $table->foreignId('jefe_inmediato_id')->nullable()->constrained('users');
            $table->foreignId('th_tipo_plantilla_id')->nullable()->constrained('th_tipo_plantillas');
            $table->foreignId('estado_id')->nullable()->default(1)->constrained('estados');
            $table->softDeletes();
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
        Schema::dropIfExists('empleados');
    }
}
