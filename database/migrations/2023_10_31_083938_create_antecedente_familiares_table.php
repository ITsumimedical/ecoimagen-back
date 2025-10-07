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
        Schema::create('antecedente_familiares', function (Blueprint $table) {
            $table->id();
            $table->string('parentesco');
            $table->integer('edad')->nullable();
            $table->boolean('fallecido')->default(0)->nullable();
            $table->foreignId('medico_registra')->constrained('users');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedente_familiares');
    }
};
