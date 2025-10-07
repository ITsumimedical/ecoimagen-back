<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutelas', function (Blueprint $table) {
            $table->id();
            $table->string('radicado');
            $table->date('fecha_radica');
            $table->date('fecha_cerrada')->nullable();
            $table->text('observacion');
            $table->integer('dias');
            $table->foreignId('quien_creo_id')->constrained('users');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('municipio_id')->constrained('municipios');
            $table->foreignId('juzgado_id')->constrained('juzgados');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
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
        Schema::dropIfExists('tutelas');
    }
}
