<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriaMesaAyudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_mesa_ayudas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 300);
            $table->foreignId('areas_mesa_ayuda_id')->constrained('areas_mesa_ayudas');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
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
        Schema::dropIfExists('categoria_mesa_ayudas');
    }
}
