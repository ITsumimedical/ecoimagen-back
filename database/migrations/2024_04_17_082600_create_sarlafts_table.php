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
        Schema::create('sarlafts', function (Blueprint $table) {
            $table->id();
            $table->string('clase')->nullable();
            $table->string('sector')->nullable();
            $table->string('cual_descripcion')->nullable();
            $table->string('tipo_bienservicio')->nullable();
            $table->string('direccion')->nullable();
            $table->string('nombre_diligencia')->nullable();
            $table->string('cedula_diligencia')->nullable();
            $table->string('cargo_diligencia')->nullable();
            $table->string('email_empresa')->nullable();
            $table->string('telefono_empresa')->nullable();
            $table->string('fax')->nullable();
            $table->string('numero_contacto')->nullable();
            $table->string('tipo_solicitud')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('municipio_id')->nullable()->constrained('municipios');
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarlafts');
    }
};
