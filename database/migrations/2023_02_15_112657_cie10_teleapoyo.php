<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cie10Teleapoyo extends Migration
{

    public function up()
    {
        Schema::create('cie10_teleapoyo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teleapoyo_id')->constrained('teleapoyos');
            $table->foreignId('cie10_id')->constrained('cie10s');
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cie10_teleapoyo');
    }
}
