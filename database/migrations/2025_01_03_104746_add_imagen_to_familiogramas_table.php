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
        Schema::table('familiogramas', function (Blueprint $table) {
            $table->string('imagen')->nullable();

            $table->string('vinculos')->nullable()->change();
            $table->string('relacion_afectiva')->nullable()->change();
            $table->string('problemas_salud')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('familiogramas', function (Blueprint $table) {
            $table->dropColumn('imagen');

            $table->string('vinculos')->nullable(false)->change();
            $table->string('relacion_afectiva')->nullable(false)->change();
            $table->string('problemas_salud')->nullable(false)->change();
        });
    }
};
