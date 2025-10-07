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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->text('agudeza_visual_ojo_izquierdo')->nullable();
            $table->text('agudeza_visual_ojo_derecho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->dropColumn('agudeza_visual_ojo_izquierdo');
            $table->dropColumn('agudeza_visual_ojo_derecho');
        });
    }
};
