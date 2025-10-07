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
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->string('respiracion_bucal')->nullable();
            $table->string('succion_digital')->nullable();
            $table->string('lengua_protactil')->nullable();
            $table->string('onicofagia')->nullable();
            $table->string('queilofagia')->nullable();
            $table->string('mordisqueo')->nullable();
            $table->string('biberon')->nullable();
            $table->string('chupos')->nullable();
            $table->string('otros')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historias_clinicas', function (Blueprint $table) {
            $table->string('respiracion_bucal')->nullable();
            $table->string('succion_digital')->nullable();
            $table->string('lengua_protactil')->nullable();
            $table->string('onicofagia')->nullable();
            $table->string('queilofagia')->nullable();
            $table->string('mordisqueo')->nullable();
            $table->string('biberon')->nullable();
            $table->string('chupos')->nullable();
            $table->string('otros')->nullable();
        });
    }
};
