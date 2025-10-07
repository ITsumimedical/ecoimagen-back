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
        Schema::create('proveedores_compras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_proveedor');
            $table->integer('NIT');
            $table->string('nombre_representante');
            $table->integer('telefono');
            $table->string('direccion');
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->string('email')->nullable();
            $table->string('actividad_economica');
            $table->string('modalidad_vinculacion');
            $table->string('forma_pago');
            $table->string('tiempo_entrega');
            $table->foreignId('area_id')->constrained('areas_proveedores');
            $table->string('tipo_proveedor');
            $table->boolean('estado')->default(true);
            $table->timestamp('fecha_ingreso');
            $table->foreignId('linea_id')->constrained('lineas_compras');
            $table->string('observaciones'); // OJO PONER (max)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores_compras');
    }
};
