<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaquetesServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paquete_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cup_id')->constrained('cups');
            $table->string('codigo');
            $table->string('nombre');
            $table->text('descripcion');
            $table->double('precio', 13, 0);
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
        Schema::dropIfExists('paquete_servicios');
    }
}
