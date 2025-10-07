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
        Schema::create('representante_legals', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('tipo_doc')->nullable();
            $table->string('num_doc')->nullable();
            $table->string('fecha_exp')->nullable();
            $table->string('fecha_nac')->nullable();
            $table->string('otra_nacionalidad')->nullable();
            $table->string('emali')->nullable();
            $table->string('direccion_reci')->nullable();
            $table->string('pais_reci')->nullable();
            $table->string('telefono')->nullable();
            $table->string('cargo_publico')->nullable();
            $table->string('poder_publico')->nullable();
            $table->string('reconocimento_publico')->nullable();
            $table->string('ocupacion')-> nullable();
            $table->string('donde_trabaja')->nullable();
            $table->string('obli_tibutarias')->nullable();
            $table->string('descripcion_obliga')->nullable();
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('sarlaft_id')->nullable()->constrained('sarlafts');
            $table->foreignId('ciudad_recidencia_id')->nullable()->constrained('departamentos');
            $table->foreignId('deparamento_recidencia_id')->nullable()->constrained('departamentos');
            $table->foreignId('lugar_nacimiento_id')->nullable()->constrained('municipios');
            $table->foreignId('lugar_expedicion_id')->nullable()->constrained('municipios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representante_legals');
    }
};
