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
        Schema::create('seguimiento_concurrencias', function (Blueprint $table) {
            $table->id();
            $table->text('notas');
            $table->text('nota_dss')->nullable();
            $table->text('nota_aac')->nullable();
            $table->text('nota_lc')->nullable();
            $table->boolean('nota_ingreso')->default(0);
            $table->foreignId('concurrencia_id')->nullable()->constrained('concurrencias');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('user_notadss_id')->nullable()->constrained('users');
            $table->foreignId('user_notaaac_id')->nullable()->constrained('users');
            $table->foreignId('user_notalc_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_concurrencias');
    }
};
