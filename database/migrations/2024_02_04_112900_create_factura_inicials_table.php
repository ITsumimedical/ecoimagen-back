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
        Schema::create('factura_inicials', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->string('numero')->nullable();
            $table->date('fecha')->nullable();
            $table->string('cod_int')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('presentacion')->nullable();
            $table->string('nom_com')->nullable();
            $table->string('cum')->nullable();
            $table->string('lote')->nullable();
            $table->date('fecha_vence')->nullable();
            $table->string('laboratorio')->nullable();
            $table->integer('embalaje')->nullable();
            $table->integer('cajas')->nullable();
            $table->integer('unidades')->nullable();
            $table->decimal('valor',14,2)->nullable();
            $table->integer('total')->nullable();
            $table->string('nit')->nullable();
            $table->string('pedido')->nullable();
            $table->decimal('unidades_caja_emb',14,2)->nullable();
            $table->decimal('valor_unitario',14,2)->nullable();
            $table->integer('bodega_id')->nullable();
            $table->integer('medicamento_id')->nullable();
            $table->string('user')->nullable();
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_inicials');
    }
};
