<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_termina');
            $table->foreignId('ambito_id')->constrained('ambitos');
            $table->boolean('capitado')->default(false);
            $table->boolean('PGP')->default(false);
            $table->boolean('evento')->default(false);
            $table->text('descripcion')->nullable();
            $table->foreignId('prestador_id')->constrained('prestadores');
            $table->foreignId('entidad_id')->constrained('entidades');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('contratos');
    }
}
