<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfiliadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afiliados', function (Blueprint $table) {
            $table->id();
            $table->string('id_afiliado')->nullable();
            $table->string('region')->nullable();
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->foreignId('tipo_documento')->nullable()->constrained('tipo_documentos');
            $table->string('numero_documento')->nullable();
            $table->string('sexo')->nullable();
            $table->date('fecha_afiliacion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->bigInteger('edad_cumplida')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular1')->nullable();
            $table->string('celular2')->nullable();
            $table->string('correo1')->nullable();
            $table->string('correo2')->nullable();
            $table->string('direccion_Residencia_cargue')->nullable();
            $table->string('direccion_Residencia_numero_exterior')->nullable();
            $table->string('direccion_Residencia_via')->nullable();
            $table->string('direccion_Residencia_numero_interior')->nullable();
            $table->string('direccion_Residencia_interior')->nullable();
            $table->string('direccion_Residencia_barrio')->nullable();
            $table->string('discapacidad')->nullable();
            $table->string('grado_discapacidad')->nullable();
            $table->string('parentesco')->nullable();
            $table->string('tipo_documento_cotizante')->nullable()->constrained('tipo_documentos');
            $table->string('numero_documento_cotizante')->nullable();
            $table->string('tipo_cotizante')->nullable();
            $table->string('categorizacion')->nullable();
            $table->string('nivel')->nullable();
            $table->string('sede_odontologica')->nullable();
            $table->foreignId('subregion_id')->nullable()->constrained('subregiones');
            $table->foreignId('departamento_afiliacion_id')->nullable()->constrained('departamentos');
            $table->foreignId('municipio_afiliacion_id')->nullable()->constrained('municipios');
            $table->foreignId('departamento_atencion_id')->nullable()->constrained('departamentos');
            $table->foreignId('municipio_atencion_id')->nullable()->constrained('municipios');
            $table->foreignId('ips_id')->nullable()->constrained('reps');
            $table->foreignId('medico_familia1_id')->nullable()->constrained('users');
            $table->foreignId('medico_familia2_id')->nullable()->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_afiliacion_id')->nullable()->constrained('estados');
            $table->foreignId('tipo_afiliado_id')->nullable()->constrained('tipo_afiliados');
            $table->foreignId('tipo_afiliacion_id')->nullable()->constrained('tipo_afiliacions');
            $table->foreignId('dpto_residencia_id')->nullable()->constrained('departamentos');
            $table->foreignId('mpio_residencia_id')->nullable()->constrained('municipios');
            $table->foreignId('entidad_id')->nullable()->constrained('entidades');
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
        Schema::dropIfExists('afiliados');
    }
}
