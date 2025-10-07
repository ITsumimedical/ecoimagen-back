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
        Schema::create('eventos_seguridads', function (Blueprint $table) {
            $table->id();
            $table->string('evento');
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('eventos_seguridads');
    }
};
