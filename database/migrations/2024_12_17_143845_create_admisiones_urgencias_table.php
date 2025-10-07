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
        Schema::create('admisiones_urgencias', function (Blueprint $table) {
            $table->id();
            $table->string('causa_muerte')->nullable();
            $table->string('causa_externa')->nullable();
            $table->boolean('estado_urgencia')->default(false);
            $table->boolean('estado_salida')->default(false)->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->date('fecha_salida');
            $table->string('destino_usuario')->nullable();
            $table->string('nombre_acompañante')->nullable();
            $table->string('telefono_acompañante')->nullable();
            $table->foreignId('sede_id')->constrained('reps');
            $table->foreignId('user_id')->constrained('users');
            $table->string('via_ingreso')->nullable();
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admisiones_urgencias');
    }
};
