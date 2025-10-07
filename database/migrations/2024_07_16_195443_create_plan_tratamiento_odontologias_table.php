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
        Schema::create('plan_tratamiento_odontologias', function (Blueprint $table) {
            $table->id();
            $table->text('operatoria')->nullable();
            $table->text('periodancia')->nullable();
            $table->text('endodoncia')->nullable();
            $table->text('cirugia_oral')->nullable();
            $table->text('remision')->nullable();
            $table->text('educacion_higiene_oral')->nullable();
            $table->text('control_de_placa')->nullable();
            $table->text('profilaxis')->nullable();
            $table->text('detrartraje')->nullable();
            $table->text('topizacion_barniz_fluor')->nullable();
            $table->text('sellantes')->nullable();
            $table->string('remision_rias')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_tratamiento_odontologias');
    }
};
