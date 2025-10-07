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
        Schema::create('actividad_internacionals', function (Blueprint $table) {
            $table->id();
            $table->string('transa_monedaextr')->nullable();
            $table->string('cual_moneda')->nullable();
            $table->string('otra_moneda')->nullable();
            $table->string('produc_extranjeros')->nullable();
            $table->string('cual_prodc')->nullable();
            $table->string('pais_operaciones')->nullable();
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('sarlaft_id')->nullable()->constrained('sarlafts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_internacionals');
    }
};
