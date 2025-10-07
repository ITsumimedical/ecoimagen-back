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
        Schema::create('revision_sarlafts', function (Blueprint $table) {
            $table->id();
            $table->string('revision');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('sarlaft_id')->constrained('sarlafts');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision_sarlafts');
    }
};
