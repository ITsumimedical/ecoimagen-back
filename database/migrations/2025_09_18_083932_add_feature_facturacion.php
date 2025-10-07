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
        Schema::create('factura_resoluciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('prefijo');
            $table->timestamp('fecha_expedicion');
            $table->timestamp('fecha_vencimiento');
            $table->unsignedBigInteger('rango_inicio');
            $table->unsignedBigInteger('rango_fin');
            $table->unsignedBigInteger('actual')->default(0);
            $table->timestamps();
        });

        Schema::create('factura_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email');
            $table->string('direccion')->nullable();
            $table->integer('tipo_documento');
            $table->string('documento');
            $table->integer('digito_verificacion')->nullable();
            $table->integer('regimen')->nullable();
            $table->integer('responsabilidad')->nullable();
            $table->integer('tipo_organizacion')->nullable();
            $table->integer('municipalidad')->nullable();
            $table->timestamps();
        });

        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique')->unique();
            $table->foreignId('resolucion_id')->constrained('factura_resoluciones');
            $table->foreignId('cliente_id')->constrained('factura_clientes');
            $table->string('numero');
            $table->unsignedBigInteger('consecutivo');
            $table->string('nota')->nullable();
            $table->double('subtotal', 20, 2);
            $table->double('descuento')->default(0);
            $table->double('total', 20, 2);
            $table->boolean('multiusuario')->default(false);
            $table->boolean('emitida')->default(false);
            $table->jsonb('dian_respuesta')->nullable();
            $table->string('cufe', 1000)->nullable();
            $table->string('zip')->nullable();
            $table->timestamp('fecha')->useCurrent();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('factura_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained('facturas')->onDelete('cascade');
            $table->string('descripcion');
            $table->integer('cantidad');
            $table->double('precio_unitario', 20, 2);
            $table->double('subtotal', 20, 2)->default(0);
            $table->double('total', 20, 2)->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_detalles');
        Schema::dropIfExists('facturas');
        Schema::dropIfExists('factura_clientes');
        Schema::dropIfExists('factura_resoluciones');
    }
};
