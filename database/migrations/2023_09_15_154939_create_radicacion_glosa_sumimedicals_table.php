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
        Schema::create('radicacion_glosa_sumimedicals', function (Blueprint $table) {
            $table->id();
            $table->text('respuesta_sumimedical')->nullable();
            $table->string('valor_aceptado')->nullable();
            $table->string('valor_no_aceptado')->nullable();
            $table->text('acepta_ips')->nullable();
            $table->text('levanta_sumi')->nullable();
            $table->text('no_acuerdo')->nullable();
            $table->foreignId('glosa_id')->nullable()->constrained('glosas');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radicacion_glosa_sumimedicals');
    }
};
