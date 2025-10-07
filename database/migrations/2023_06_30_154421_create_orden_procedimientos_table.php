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
        Schema::create('orden_procedimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->foreignId('cup_id')->constrained('cups');
            $table->foreignId('rep_id')->nullable()->constrained('reps');
            $table->foreignId('estado_id')->constrained('estados');
            $table->integer('cantidad');
            $table->integer('valor_tarifa')->nullable();
            $table->date('fecha_vigencia');
            $table->text('observacion')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_procedimientos');
    }
};
