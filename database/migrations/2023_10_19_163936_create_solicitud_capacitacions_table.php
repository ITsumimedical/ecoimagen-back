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
        Schema::create('solicitud_capacitacions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_requerimiento');
            $table->string('fuente');
            $table->string('otro_fuente')->nullable();
            $table->text('descripcion');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_capacitacions');
    }
};
