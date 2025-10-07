<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeguimientoActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimiento_actividades', function (Blueprint $table) {
            $table->id();
            $table->string('respuesta', 2500);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('mesa_ayuda_id')->constrained('mesa_ayudas');
            $table->integer('adjunto_mesa_ayuda_id')->nullable();
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
        Schema::dropIfExists('seguimiento_actividades');
    }
}
