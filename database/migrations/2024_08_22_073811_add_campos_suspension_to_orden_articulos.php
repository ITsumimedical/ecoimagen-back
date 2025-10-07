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
        Schema::table('orden_articulos', function (Blueprint $table) {
            $table->text('motivo_suspension')->nullable();
            $table->date('fecha_suspension')->nullable();
            $table->foreignId('funcionario_suspende')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_articulos', function (Blueprint $table) {
            $table->dropColumn('motivo_suspension');
            $table->dropColumn('fecha_suspension');
            $table->dropForeign(['funcionario_suspende']);
            $table->dropColumn('funcionario_suspende');
        });
    }
};
