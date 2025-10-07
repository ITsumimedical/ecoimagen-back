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
        Schema::create('formulariopqrsfs', function (Blueprint $table) {
            $table->id();
            $table->string('quien_genera');
            $table->string('documento_genera')->nullable();
            $table->string('nombre_genera')->nullable();
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->string('priorizacion')->nullable();
            $table->string('atributo_calidad')->nullable();
            $table->string('deber')->nullable();
            $table->string('derecho')->nullable();
            $table->boolean('reabierta')->default(false);
            $table->text('descripcion');
            $table->foreignId('canal_id')->nullable()->constrained('canalpqrsfs');
            $table->foreignId('tipo_solicitud_id')->constrained('tipo_solicitudpqrsfs');
            $table->foreignId('afiliado_id')->constrained('afiliados');
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
        Schema::dropIfExists('formulariopqrsfs');
    }
};
