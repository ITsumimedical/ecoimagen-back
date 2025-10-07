<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCodesumisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codesumis', function (Blueprint $table) {
            $table->id();
            $table->string("codigo");
            $table->string("nombre");
            $table->boolean("requiere_autorizacion");
            $table->integer("nivel_ordenamiento");
            $table->string("principio_activo");
            $table->integer("nivel_portabilidad");
            $table->string("tipo_codesumi");
            $table->string("unidad_presentacion");
            $table->string("via");
            $table->foreignId('estado_id')->constrained('estados');
            /** Primero los Campos luego las relaciones*/

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
        Schema::dropIfExists('codesumis');
    }
}
