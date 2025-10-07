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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->text('documento_afiliado')->nullable();
            $table->integer('edad_afiliado')->nullable();
            $table->text('sexo_afiliado')->nullable();
            $table->text('tipo_documento_afiliado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('documento_afiliado');
            $table->dropColumn('edad_afiliado');
            $table->dropColumn('sexo_afiliado');
            $table->dropColumn('tipo_documento_afiliado');
        });
    }
};
