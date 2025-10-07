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
        Schema::create('georeferenciacions', function (Blueprint $table) {
            $table->id();
            $table->string('zona');
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('georeferenciacions');
    }
};
