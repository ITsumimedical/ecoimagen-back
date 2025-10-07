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
        Schema::create('informacion_responsables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('telefono')->nullable();
            $table->string('celular');
            $table->string('direccion')->nullable();
            $table->string('parentesco');
            $table->foreignId('ingreso_domiciliario_id')->constrained('ingreso_domiciliarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_responsables');
    }
};
