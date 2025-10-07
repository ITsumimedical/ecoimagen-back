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
        Schema::create('conteo_inventarios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('conteo1')->nullable();
            $table->bigInteger('conteo2')->nullable();
            $table->bigInteger('value1')->nullable();
            $table->bigInteger('conteo3')->nullable();
            $table->bigInteger('conteo4')->nullable();
            $table->bigInteger('saldo_inicial')->nullable();
            $table->foreignId('lote_id')->nullable()->constrained('lotes');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('estado_id')->nullable()->default(1)->constrained('estados');
            $table->foreignId('inventario_farmacia_id')->nullable()->constrained('inventario_farmacias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conteo_inventarios');
    }
};
