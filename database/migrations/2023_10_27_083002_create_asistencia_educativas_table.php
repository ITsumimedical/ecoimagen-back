<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asistencia_educativas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('ambito')->nullable();
            $table->string('finalidad')->nullable();
            $table->string('tema')->nullable();
            $table->foreignId('cup_id')->constrained('cups');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('asistencia_educativas');
    }
};
