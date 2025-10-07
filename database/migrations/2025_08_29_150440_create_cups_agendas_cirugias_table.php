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
        Schema::create('cups_agendas_cirugias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_cirugia_id')->constrained('agendamiento_cirugias');
            $table->foreignId('cup_id')->constrained('cups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cups_agendas_cirugias');
    }
};
