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
        Schema::create('sucesion_evolutivas', function (Blueprint $table) {
            $table->id();
            $table->text('sucesion_evolutiva_conducta');
            $table->text('sucesion_evolutiva_lenguaje');
            $table->text('sucesion_evolutiva_area');
            $table->text('sucesion_evolutiva_conducta_personal');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucesion_evolutivas');
    }
};
