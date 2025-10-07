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
        Schema::create('carga_inicials', function (Blueprint $table) {
            $table->id();
            $table->string('id_afiliado');
            $table->string('Region');
            $table->string('UT');
            $table->string('primer_nombre');
            $table->string('segundo_nombre');
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('sexo');
            $table->string('fecha_afiliado');
            $table->string('fecha_nacimiento');
            $table->string('edad');
            $table->string('discapacidad');
            $table->string('grado_discapacidad');
            $table->string('tipo_afiliado');
            $table->string('orden_judicial');
            $table->string('numero_folio');
            $table->string('fecha_emision');
            $table->string('parentesco');
            $table->string('tipo_documento_cotizante');
            $table->string('numero_documento_cotizante');
            $table->string('tipo_cotizante');
            $table->string('estado_afiliado');
            $table->string('dane_municipio');
            $table->string('municipio_afiliacion');
            $table->string('dane_departamento');
            $table->string('departamento_afiliacion');
            $table->string('subregion');
            $table->string('departamento_atencion');
            $table->string('municipio_atencion');
            $table->string('IPS');
            $table->string('sede_odontologica');

            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carga_inicials');
    }
};
