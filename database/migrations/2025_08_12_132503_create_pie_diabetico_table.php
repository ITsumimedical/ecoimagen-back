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
        Schema::create('pie_diabetico', function (Blueprint $table) {
            $table->id();
            $table->string('presencia');
            $table->string('grado');
            $table->string('estadio');
            $table->string('descripcion');
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pie_diabetico');
    }
};
