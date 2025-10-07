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
        Schema::create('cambios_ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('observacion');
            $table->string('estado')->nullable();
            $table->foreignId('orden_articulo_id')->nullable()->constrained('orden_articulos');
            $table->foreignId('orden_procedimiento_id')->nullable()->constrained('orden_procedimientos');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cambios_ordenes');
    }
};
