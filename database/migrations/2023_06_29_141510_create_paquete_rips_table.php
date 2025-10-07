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
        Schema::create('paquete_rips', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('parcial')->nullable();
            $table->text('motivo')->nullable();
            $table->string('nombre_rep')->nullable();
            $table->string('codigo')->nullable();
            $table->string('entidad')->nullable();
            $table->string('ac_size')->nullable();
            $table->string('af_size')->nullable();
            $table->string('ah_size')->nullable();
            $table->string('am_size')->nullable();
            $table->string('ap_size')->nullable();
            $table->string('at_size')->nullable();
            $table->string('au_size')->nullable();
            $table->string('ct_size')->nullable();
            $table->string('us_size')->nullable();
            $table->string('mes')->nullable();
            $table->string('anio')->nullable();
            $table->string('ruta')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('estado_id')->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_rips');
    }
};
