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
        Schema::create('paraclinicos_odontologias', function (Blueprint $table) {
            $table->id();
            $table->text('laboratorio')->nullable();
            $table->text('lectura_radiografica')->nullable();
            $table->text('otros')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paraclinicos_odontologias');
    }
};
