<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePrestadorThsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestador_ths', function (Blueprint $table) {
            $table->id();
            $table->string('nit');
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->foreignId('tipo_prestador_id')->constrained('tipo_prestador_ths');
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
        Schema::dropIfExists('prestador_ths');
    }
}
