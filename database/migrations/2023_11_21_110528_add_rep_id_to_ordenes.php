<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->foreignId('rep_id')->nullable()->constrained('reps');
        });
    }


    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->foreignId('rep_id')->nullable()->constrained('reps');
        });
    }
};
