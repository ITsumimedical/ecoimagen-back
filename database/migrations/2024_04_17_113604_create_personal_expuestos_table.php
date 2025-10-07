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
        Schema::create('personal_expuestos', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('relacion')->nullable();
            $table->string('entidad')->nullable();
            $table->string('cargo')->nullable();
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
        Schema::dropIfExists('personal_expuestos');
    }
};
