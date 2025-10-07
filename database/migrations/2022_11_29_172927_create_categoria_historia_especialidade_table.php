<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriaHistoriaEspecialidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_historia_especialidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('especialidade_id')->constrained('especialidades');
            $table->foreignId('categoria_historia_id')->constrained('categoria_historias');
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
        Schema::dropIfExists('categoria_historia_especialidade');
    }
}
