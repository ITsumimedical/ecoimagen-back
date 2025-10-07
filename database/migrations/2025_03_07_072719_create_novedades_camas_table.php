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
        Schema::create('novedades_camas', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->foreignId('tipo_id')->constrained('tipos');
            $table->foreignId('cama_id')->constrained('camas');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades_camas');
    }
};
