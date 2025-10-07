<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuzgadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juzgados', function (Blueprint $table) {
            $table->id()->comment('tipo:bigInteger,Numero identificador incremental');
            $table->string('nombre')->comment('tipo:string,Nombre de los juzgados');
            $table->boolean('estado')->default(true)->comment('tipo:boolean, Estado de los juzgados');
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
        Schema::dropIfExists('juzgado_tutelas');
    }
}
