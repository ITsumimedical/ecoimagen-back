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
            $table->boolean('requiere_autorizacion')->nullable()->change();
            $table->integer('nivel_ordenamiento')->nullable()->change();
            $table->string('tipo_codesumi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codesumis', function (Blueprint $table) {
            $table->boolean('requiere_autorizacion')->nullable(false)->change();
            $table->integer('nivel_ordenamiento')->nullable(false)->change();
            $table->string('tipo_codesumi')->nullable(false)->change();
        });
    }
};
