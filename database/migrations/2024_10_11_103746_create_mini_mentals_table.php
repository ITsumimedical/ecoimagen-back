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
        Schema::create('mini_mentals', function (Blueprint $table) {
            $table->id();
            $table->string('anio');
            $table->string('mes');
            $table->string('fecha_hoy');
            $table->string('hora');
            $table->string('pais');
            $table->string('ciudad');
            $table->string('departamento');
            $table->string('sitio_lugar_esta');
            $table->string('piso_barrio_vereda_esta');
            $table->string('memoria_repeticiones');
            $table->string('atencion_calculo');
            $table->string('evocacion');
            $table->string('denominacion');
            $table->string('repite_frase');
            $table->string('obedece_orden');
            $table->string('obedece_dos_ordenes');
            $table->string('escribe_frase_tarjeta');
            $table->string('realiza_bien_diseño');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mini_mentals');
    }
};
