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
        Schema::create('plantilla_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('orden');
            $table->foreignId('plantilla_historia_id')->constrained('plantilla_historias');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_categorias');
    }
};
