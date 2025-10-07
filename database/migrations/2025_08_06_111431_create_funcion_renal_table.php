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
        Schema::create('funcion_renal', function (Blueprint $table) {
            $table->id();
            $table->float('resultado_cockcroft_gault');
            $table->float('resultado_ckd_epi');
            $table->string('valor_creatinina');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcion_renal');
    }
};
