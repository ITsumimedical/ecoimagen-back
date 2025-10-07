<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCampoHistoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campo_historias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ciclo_vida');
            $table->boolean('requerido');
            $table->integer('columnas')->nullable();
            $table->integer('orden')->nullable();
            $table->string('opciones')->nullable();
            $table->foreignId('categoria_historia_id')->constrained('categoria_historias');
            $table->foreignId('subcategoria_id')->nullable()->constrained('campo_historias');
            $table->foreignId('tipo_campo_id')->constrained('tipo_campos');
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
        Schema::dropIfExists('campo_historias');
    }
}
