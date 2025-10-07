<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('integrantes_familia_caracterizacion_ecis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos');
            $table->string('numero_documento');
            $table->date('fecha_nacimiento');
            $table->string('sexo');
            $table->string('rol_familia');
            $table->string('rol_familia_otro')->nullable();
            $table->text('ocupacion');
            $table->string('nivel_educativo');
            $table->foreignId('tipo_afiliacion_id')->constrained('tipo_afiliacions');
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->string('grupo_especial_proteccion');
            $table->string('pertenencia_etnica');
            $table->string('comunidad_pueblo_indigena')->nullable();
            $table->string('discapacidad');
            $table->boolean('condiciones_salud_cronica');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrantes_familia_caracterizacion_ecis');
    }
};
