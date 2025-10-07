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
        Schema::create('paraclinicos', function (Blueprint $table) {
            $table->id();
            $table->text('resultadoCreatinina')->nullable();
            $table->text('ultimaCreatinina')->nullable();
            $table->text('resultaGlicosidada')->nullable();
            $table->text('fechaGlicosidada')->nullable();
            $table->text('resultadoAlbuminuria')->nullable();
            $table->text('fechaAlbuminuria')->nullable();
            $table->text('resultadoColesterol')->nullable();
            $table->text('fechaColesterol')->nullable();
            $table->text('resultadoHdl')->nullable();
            $table->text('fechaHdl')->nullable();
            $table->text('resultadoLdl')->nullable();
            $table->text('fechaLdl')->nullable();
            $table->text('resultadoTrigliceridos')->nullable();
            $table->text('fechaTrigliceridos')->nullable();
            $table->text('resultadoGlicemia')->nullable();
            $table->text('fechaGlicemia')->nullable();
            $table->text('resultadoPht')->nullable();
            $table->text('fechaPht')->nullable();
            $table->text('resultadoHemoglobina')->nullable();
            $table->text('albumina')->nullable();
            $table->text('fechaAlbumina')->nullable();
            $table->text('fosforo')->nullable();
            $table->text('fechaFosforo')->nullable();
            $table->text('resultadoEkg')->nullable();
            $table->text('fechaEkg')->nullable();
            $table->text('glomerular')->nullable();
            $table->text('fechaGlomerular')->nullable();
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->text('nombreParaclinico')->nullable();
            $table->float('resultadoParaclinico')->nullable();
            $table->boolean('checkboxParaclinicos')->nullable();
            $table->date('fechaParaclinico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paraclinicos');
    }
};
