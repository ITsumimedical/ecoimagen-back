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
        Schema::create('cobro_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->integer('valor');
            $table->string('medio_pago')->nullable();
            $table->date('fecha_cobro')->nullable();
            $table->foreignId('usuario_cobra')->nullable()->constrained('users');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('orden_articulo_id')->nullable()->constrained('orden_articulos');
            $table->foreignId('orden_procedimiento_id')->nullable()->constrained('orden_procedimientos');
            $table->foreignId('orden_codigo_propio_id')->nullable()->constrained('orden_codigo_propios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobro_servicios');
    }
};
