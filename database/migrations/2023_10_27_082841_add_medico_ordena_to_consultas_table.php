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
        Schema::table('consultas', function (Blueprint $table) {

            $table->boolean('cita_no_programada')->default(false);
            $table->foreignId('especialidad_id')->nullable()->constrained('especialidades');
            $table->foreignId('cita_id')->nullable()->constrained('citas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->boolean('cita_no_programada')->default(false);
            $table->foreignId('especialidad_id')->nullable()->constrained('especialidades');
            $table->foreignId('cita_id')->nullable()->constrained('citas');
        });
    }
};
