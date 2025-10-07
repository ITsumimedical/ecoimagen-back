<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('cum')->nullable();
            $table->integer("nivel_ordenamiento");
            $table->string('codigo_barras')->nullable();
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('codesumi_id')->constrained('codesumis');
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
        Schema::dropIfExists('medicamentos');
    }
}
