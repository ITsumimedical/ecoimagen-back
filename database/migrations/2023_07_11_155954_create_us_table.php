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
        Schema::create('us', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_admin');
            $table->string('tipo_usuario');
            $table->string('edad');
            $table->string('unidad_mediad');
            $table->string('zona_residencia');
            $table->string('numero_documento')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('primer_nombre')->nullable();
            $table->string('segundo_nombre')->nullable();
            $table->string('sexo')->nullable();
            $table->string('codigo_departamento_residencia')->nullable();
            $table->string('codigo_municipio_residencia')->nullable();
            $table->foreignId('paquete_rip_id')->nullable()->constrained('paquete_rips');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('us');
    }
};
