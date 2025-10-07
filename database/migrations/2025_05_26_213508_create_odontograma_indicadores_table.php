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
        Schema::create('odontograma_indicadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');

            $table->integer('cop_c')->default(0);
            $table->integer('cop_o')->default(0);
            $table->integer('cop_p')->default(0);

            // CEO
            $table->integer('ceo_c')->default(0);
            $table->integer('ceo_e')->default(0);
            $table->integer('ceo_o')->default(0);

            // Informe 202
            $table->integer('sano')->default(0);
            $table->integer('caries_no_cavitacional')->default(0);
            $table->integer('caries_cavitacional')->default(0);
            $table->integer('obturado_por_caries')->default(0);
            $table->integer('perdido_por_caries')->default(0);

            //Resultado
            $table->string('resultado_informe')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontograma_indicadores');
    }
};
