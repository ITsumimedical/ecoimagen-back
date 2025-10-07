<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCie10sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cie10s', function (Blueprint $table) {

            $table->id();
            $table->string('capitulo')->nullable();
            $table->string('nombre_capitulo')->nullable();
            $table->string('codigo_cie10')->nullable();
            $table->string('descripcion', 1000)->nullable();
            $table->string('limitada_sexo')->nullable();
            $table->string('inferior_edad')->nullable();
            $table->string('superior_edad')->nullable();
            $table->string('visible')->nullable();
            $table->text('nombre')->nullable();
            $table->boolean('estado')->default(true)->nullable();
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
        Schema::dropIfExists('cie10s');
    }
}
