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
        Schema::create('recibe_quimioterapias', function (Blueprint $table) {
            $table->id();
            $table->boolean('recibe_quimioterapia');
            $table->text('descripcion_quimioterapia');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibe_quimioterapias');
    }
};
