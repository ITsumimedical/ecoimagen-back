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
        Schema::create('costo_evitables', function (Blueprint $table) {
            $table->id();
            $table->string('costo');
            $table->string('objecion');
            $table->integer('valor');
            $table->string('descripcion')->nullable();
            $table->foreignId('ingreso_concurrencia_id')->constrained('ingreso_concurrencias');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costo_evitables');
    }
};
