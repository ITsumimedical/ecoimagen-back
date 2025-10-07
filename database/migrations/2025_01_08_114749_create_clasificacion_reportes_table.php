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
        Schema::create('clasificacion_reportes', function (Blueprint $table) {
            $table->id(); // ID único para cada reporte
            $table->string('nombre', 255); // Nombre del reporte
            $table->string('url', 255)->unique(); // URL identificadora
            $table->string('funcion_sql', 255); // Nombre de la función SQL
            $table->json('campos_requeridos'); // Campos requeridos en formato JSON
            $table->string('permiso', 255); // Permiso necesario para acceder al reporte
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clasificacion_reportes');
    }
};
