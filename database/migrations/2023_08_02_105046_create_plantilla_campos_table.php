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
        Schema::create('plantilla_campos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ciclo_vida');
            $table->boolean('requerido');
            $table->integer('columnas')->nullable();
            $table->foreignId('plantilla_categoria_id')->constrained('plantilla_categorias');
            $table->foreignId('subcategoria_id')->constrained('plantilla_campos');
            $table->foreignId('tipo_campo_id')->constrained('tipo_campos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_campos');
    }
};
