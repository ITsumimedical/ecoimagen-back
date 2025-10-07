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
        Schema::create('empalme', function (Blueprint $table) {
            $table->id();
            $table->string('acepta_represa')->nullable();
            $table->string('tutela')->nullable();
            $table->string('tipo_servicio')->nullable();
            $table->foreignId('cie10s_id')->constrained('cie10s');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->boolean('empalme')->default('0');
            $table->text('observaciones_contratista')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empalme');
    }
};


