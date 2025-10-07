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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_orden_id')->default(1)->constrained('tipo_ordenes');
            $table->foreignId('consulta_id')->default(1)->constrained('consultas');
            $table->foreignId('user_id')->default(1)->constrained('users');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->string('paginacion')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
