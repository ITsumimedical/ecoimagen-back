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
        Schema::create('eventos_ingresos_concurrencias', function (Blueprint $table) {
            $table->id();
            $table->text('evento');
            $table->text('observaciones');
            $table->string('tipo_evento');
            $table->foreignId('ingreso_concurrencia_id')->constrained('ingreso_concurrencias');
            $table->foreignId('user_id')->constrained('users');
            $table->text('motivo_eliminacion')->nullable();
            $table->foreignId('user_elimina_id')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_ingresos_concurrencias');
    }
};
