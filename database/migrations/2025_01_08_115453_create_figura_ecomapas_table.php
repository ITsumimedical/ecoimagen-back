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
        Schema::create('figura_ecomapas', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->integer('edad')->nullable();
            $table->integer('pos_x');
            $table->integer('pos_y');
            $table->text('class');
            $table->boolean('principal')->default(false);
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figura_ecomapas');
    }
};
