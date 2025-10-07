<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cups', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('nombre', 1000)->nullable();
            $table->string('genero')->nullable();
            $table->string('edad_inicial')->nullable();
            $table->string('edad_final')->nullable();
            $table->string('archivo')->nullable();
            $table->boolean('quirurgico')->default(true);
            $table->boolean('diagnostico_requerido')->default(true);
            $table->integer('nivel_ordenamiento')->nullable();
            $table->integer('nivel_portabilidad')->nullable();
            $table->boolean('requiere_auditoria')->default(true);
            $table->integer('periodicidad')->nullable();
            $table->integer('cantidad_max_ordenamiento')->nullable();
            $table->foreignId('ambito_id')->constrained('ambitos');
            $table->boolean('activo')->default(true);
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
        Schema::dropIfExists('cups');
    }
}
