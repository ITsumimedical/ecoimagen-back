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
        Schema::create('precio_entidad_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->float('subtotal');
            $table->float('iva')->nullable();
            $table->float('total')->nullable();
            $table->float('precio_maximo')->nullable();
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->foreignId('medicamento_id')->constrained('medicamentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_entidad_medicamentos');
    }
};
