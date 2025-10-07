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
        Schema::create('cup_ginecologicos', function (Blueprint $table) {
            $table->id();
            $table->string('estado_ginecologia');
            $table->string('descripcion_citologia');
            $table->foreignId('cup_citologia_id')->constrained('cups');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cup_ginecologicos');
    }
};
