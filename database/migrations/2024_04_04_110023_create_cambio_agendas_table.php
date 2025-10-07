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
        Schema::create('cambio_agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('agendas');
            $table->foreignId('user_id')->constrained('users');
            $table->text('motivo');
            $table->string('accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cambio_agendas');
    }
};
