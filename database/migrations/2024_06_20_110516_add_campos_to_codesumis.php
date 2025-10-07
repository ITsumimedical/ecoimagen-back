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
        Schema::table('codesumis', function (Blueprint $table) {
            $table->float('concentracion_1')->nullable();
            $table->float('concentracion_2')->nullable();
            $table->float('concentracion_3')->nullable();
            $table->string('abc')->nullable();
            $table->string('estado_normativo')->nullable();
            $table->boolean('control_especial')->nullable();
            $table->boolean('critico')->nullable();
            $table->boolean('regulado')->nullable();
            $table->boolean('activo_horus')->nullable();
            $table->boolean('alto_costo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codesumis', function (Blueprint $table) {
            //
        });
    }
};
