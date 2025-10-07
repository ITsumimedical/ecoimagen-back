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
        Schema::create('afs', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_identificacion');
            $table->string('numero_identificacion');
            $table->string('numero_factura');
            $table->string('fechaexpedicion_factura');
            $table->string('fecha_inicio');
            $table->string('fecha_final');
            $table->string('codigo_entidad')->default('RES004');
            $table->string('nombre_admin');
            $table->string('numero_contrato')->nullable();
            $table->string('plan_beneficios')->nullable();
            $table->string('numero_poliza')->nullable();
            $table->string('valor_copago')->nullable();
            $table->string('valor_comision')->nullable();
            $table->string('valor_descuento')->nullable();
            $table->string('valor_neto')->nullable();
            $table->string('servicio')->nullable();
            $table->string('codigo_prestador')->nullable();
            $table->string('nombre_prestador')->nullable();
            $table->dateTime('fecha_notificacion_prestador')->nullable();
            $table->dateTime('fecha_conciliacion')->nullable();
            $table->foreignId('paquete_rip_id')->constrained('paquete_rips');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afs');
    }
};
