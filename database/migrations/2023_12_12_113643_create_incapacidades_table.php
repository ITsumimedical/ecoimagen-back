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
        Schema::create('incapacidades', function (Blueprint $table) {
            $table->id();
            $table->string('contingencia')->nullable(); 
            $table->date('fecha_inicio'); 
            $table->smallInteger('dias'); 
            $table->date('fecha_final'); 
            $table->string('prorroga'); 
            $table->foreignId('consulta_id')->constrained('consultas'); 
            $table->string('descripcion_incapacidad', 1500);
            $table->foreignId('diagnostico_id')->nullable()->constrained('cie10s'); 
            $table->foreignId('colegio_id')->nullable()->constrained('colegios'); 
            $table->foreignId('usuario_realiza_id')->constrained('users'); 
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incapacidads');
    }
};
