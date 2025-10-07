<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateThPilarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('th_pilars', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('porcentaje');
            $table->integer('orden');
            $table->boolean('esta_activo');
            $table->foreignId('th_tipo_plantilla_id')->constrained('th_tipo_plantillas');
            $table->SoftDeletes();
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
        Schema::dropIfExists('th_pilars');
    }
}
