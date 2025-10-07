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
        Schema::create('apgar_familiars', function (Blueprint $table) {
            $table->id();
            $table->integer('ayuda_familia')->nullable();
            $table->integer('familia_habla_con_usted')->nullable();
            $table->integer('cosas_nuevas')->nullable();
            $table->integer('le_gusta_familia_hace')->nullable();
            $table->integer('le_gusta_familia_comparte')->nullable();
            $table->integer('resultado')->nullable();
            $table->foreignId('medico_registra')->constrained('users');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apgar_familiars');
    }
};
