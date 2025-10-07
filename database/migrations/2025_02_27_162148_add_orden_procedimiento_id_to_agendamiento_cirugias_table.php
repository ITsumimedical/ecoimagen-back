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
        Schema::table('agendamiento_cirugias', function (Blueprint $table) {
            $table->foreignId('orden_procedimiento_id')->nullable()->constrained('orden_procedimientos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamiento_cirugias', function (Blueprint $table) {
            $table->foreignId('orden_procedimiento_id')->nullable()->constrained('orden_procedimientos');
        });
    }
};
