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
        Schema::create('figuras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('edad');
            $table->integer('pos_x');
            $table->integer('pos_y');
            $table->string('class');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figuras');
    }
};
