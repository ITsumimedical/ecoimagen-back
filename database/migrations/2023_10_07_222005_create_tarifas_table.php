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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manual_tarifario_id')->constrained('manual_tarifarios');
            $table->boolean('pleno')->nullable();
            $table->float('valor')->nullable();
            $table->foreignId('rep_id')->constrained('reps');
            $table->foreignId('contrato_id')->constrained('contratos');
            $table->foreignId('user_id')->constrained('users');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
