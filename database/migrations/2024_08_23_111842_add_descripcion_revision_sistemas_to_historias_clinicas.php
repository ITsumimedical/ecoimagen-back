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
            $table->text('descripcion_revision_sistemas')->nullable();
            $table->boolean('sintomatico_respiratorio')->nullable();
            $table->boolean('sintomatico_piel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->text('descripcion_revision_sistemas')->nullable();
            $table->boolean('sintomatico_respiratorio')->nullable();
            $table->boolean('sintomatico_piel')->nullable();
        });
    }
};
