<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCupTutelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cup_tutelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actuacion_tutela_id')->constrained('actuacion_tutelas');
            $table->foreignId('cup_id')->constrained('cups');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cup_tutelas');
    }
}
