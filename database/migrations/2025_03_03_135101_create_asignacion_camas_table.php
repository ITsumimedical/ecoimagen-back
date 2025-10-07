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
        Schema::create('asignacion_camas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha');
            $table->string('tipo_cama');
            $table->foreignId('cama_id')->constrained('camas');
            $table->foreignId('admision_urgencia_id')->constrained('admisiones_urgencias');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_camas');
    }
};
