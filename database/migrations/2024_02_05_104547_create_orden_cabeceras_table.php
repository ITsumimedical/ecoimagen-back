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
        Schema::create('orden_cabeceras', function (Blueprint $table) {
            $table->id();
            $table->integer('num_orden')->nullable();
            $table->date('fecha')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('documento')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('sexo')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('codigo_ciudad')->nullable();
            $table->string('codigo_zona')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
            $table->integer('numero_peticion')->nullable();
            $table->string('piso')->nullable();
            $table->boolean('embarazo')->nullable();
            $table->string('tipo_usuario')->nullable();
            $table->string('tipo_servicio')->nullable();
            $table->string('codigo_medico')->nullable();
            $table->string('nombre_medico')->nullable();
            $table->string('codigo_cliente')->nullable();
            $table->string('nombre_cliente')->nullable();
            $table->string('codigo_cencos')->nullable();
            $table->string('nombre_cencos')->nullable();
            $table->string('nombre_sede')->nullable();
            $table->smallInteger('estado')->nullable();
            $table->boolean('urgente')->nullable();
            $table->string('codigo_diagnostico')->nullable();
            $table->string('nombre_diagnostico')->nullable();
            $table->string('id_laboratorio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_cabeceras');
    }
};
