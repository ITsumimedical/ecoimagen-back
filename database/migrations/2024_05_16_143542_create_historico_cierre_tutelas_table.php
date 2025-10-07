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
        Schema::create('historico_cierre_tutelas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_cierre');
            $table->text('motivo');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tutela_id')->constrained('tutelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_cierre_tutelas');
    }
};
