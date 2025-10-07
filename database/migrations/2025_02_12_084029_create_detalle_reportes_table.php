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
        Schema::create('detalle_reportes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_parametro');
            $table->string('orden_parametro');
            $table->string('tipo_dato');
            $table->string('origen')->nullable();
            $table->string('nombre_columna_bd')->nullable();
            $table->string('valor_columna_guardar')->nullable();
            $table->foreignId('cabecera_reporte_id')->constrained('cabecera_reportes');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_reportes');
    }
};
