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
        Schema::create('consentimientos_informados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->text('beneficios');
            $table->text('riesgos');
            $table->text('alternativas');
            $table->text('riesgo_no_aceptar');
            $table->text('informacion');
            $table->text('recomendaciones');
            $table->foreignId('cup_id')->constrained('cups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentimientos_informados');
    }
};
