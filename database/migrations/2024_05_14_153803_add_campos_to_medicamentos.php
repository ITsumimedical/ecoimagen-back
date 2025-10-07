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
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->string('marca_dispositivo')->nullable();
            $table->string('ium_primernivel')->nullable();
            $table->string('ium_segundonivel')->nullable();
            $table->string('pos')->nullable();
            $table->float('precio_maximo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->string('marca_dispositivo')->nullable();
            $table->string('ium_primernivel')->nullable();
            $table->string('ium_segundonivel')->nullable();
            $table->string('pos')->nullable();
            $table->float('precio_maximopos')->nullable();
        });
    }
};
