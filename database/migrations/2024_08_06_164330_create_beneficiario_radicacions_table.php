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
        Schema::create('beneficiario_radicacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->nullable()->constrained('tipo_documentos');
            $table->string('numero_documento')->nullable();
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('sexo')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad_cumplida')->nullable();
            $table->string('parentesco')->nullable();
            $table->string('discapacidad')->nullable();
            $table->string('grado_discapacidad')->nullable();
            $table->foreignId('pais_id')->nullable()->constrained('paises');
            $table->foreignId('departamento_afiliacion_id')->nullable()->constrained('departamentos');
            $table->foreignId('departamento_atencion_id')->nullable()->constrained('departamentos');
            $table->foreignId('municipio_afiliacion_id')->nullable()->constrained('municipios');
            $table->foreignId('municipio_atencion_id')->nullable()->constrained('municipios');
            $table->string('direccion_residencia_cargue')->nullable();
            $table->string('direccion_residencia_numero_exterior')->nullable();
            $table->string('direccion_residencia_primer_interior')->nullable();
            $table->string('direccion_residencia_segundo_interior')->nullable();
            $table->string('direccion_residencia_interior')->nullable();
            $table->string('direccion_residencia_barrio')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular1')->nullable();
            $table->string('celular2')->nullable();
            $table->string('correo1')->nullable();
            $table->string('correo2')->nullable();
            $table->foreignId('tipo_afiliado_id')->nullable()->constrained('tipo_afiliados');
            $table->foreignId('tipo_afiliacion_id')->nullable()->constrained('tipo_afiliacions');
            $table->foreignId('entidad_id')->nullable()->constrained('entidades');
            $table->string('numero_documento_cotizante')->nullable();
            $table->foreignId('solicitud_id')->nullable()->constrained('radicacion_onlines');
            $table->foreignId('tipo_beneficiario_id')->nullable()->constrained('tipo_beneficiario_radicacions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiario_radicacions');
    }
};
