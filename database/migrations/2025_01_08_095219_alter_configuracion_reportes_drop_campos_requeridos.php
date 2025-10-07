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

        // Create table campos_reporte
        Schema::create('campos_reporte', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('origen')->nullable();
            $table->string('tipoCampo');
            $table->boolean('requerido')->nullable();
            $table->string('valorDefault')->nullable();
            $table->foreignId('configuracion_reporte_id')->constrained('configuracion_reportes');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuracion_reportes', function (Blueprint $table) {
            $table->json('campos_requeridos');
        });
    }
};
