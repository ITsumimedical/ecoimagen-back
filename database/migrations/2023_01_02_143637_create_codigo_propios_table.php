<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCodigoPropiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_propios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo');
            $table->foreignId('cup_id')->constrained('cups');
            $table->string('genero')->nullable();
            $table->string('edad_inicial')->nullable();
            $table->string('edad_final')->nullable();
            $table->boolean('quirurgico')->default(true);
            $table->boolean('diagnostico_requerido')->default(true);
            $table->integer('nivel_ordenamiento')->nullable();
            $table->integer('nivel_portabilidad')->nullable();
            $table->boolean('requiere_auditoria')->default(true);
            $table->integer('periodicidad')->nullable();
            $table->integer('cantidad_max_ordenamiento')->nullable();
            $table->foreignId('ambito_id')->constrained('ambitos');
            $table->float('valor', 12);
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
        Schema::dropIfExists('codigo_propios');
    }
}
