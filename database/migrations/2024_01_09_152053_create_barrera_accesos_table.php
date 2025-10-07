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
        Schema::create('barrera_accesos', function (Blueprint $table) {
            $table->id();
            $table->text('observacion');
            $table->text('observacion_cierre')->nullable();
            $table->text('barrera')->nullable();
            $table->boolean('activo')->default(1);
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('rep_id')->nullable()->constrained('reps');
            $table->foreignId('userCrea_id')->constrained('users');
            $table->foreignId('userCierra_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barrera_accesos');
    }
};
