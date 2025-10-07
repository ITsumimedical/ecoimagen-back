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
        Schema::create('glosas', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion')->nullable();
            $table->string('valor')->nullable();
            $table->string('codigo')->nullable();
            $table->text('concepto')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_id')->nullable()->constrained('estados');
            $table->foreignId('af_id')->nullable()->constrained('afs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glosas');
    }
};
