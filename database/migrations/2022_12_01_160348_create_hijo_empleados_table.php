<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHijoEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hijo_empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('documento');
            $table->string('celular');
            $table->string('telefono');
            $table->date('fecha_nacimiento');
            $table->boolean('comparte_vivienda')->default(false);
            $table->boolean('afiliar_caja')->default(false);
            $table->boolean('afiliar_eps')->default(false);
            $table->boolean('depende_economicamente')->default(false);
            $table->integer('edad')->nullable();
            $table->foreignId('empleado_id')->constrained('empleados');
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos');
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
        Schema::dropIfExists('hijo_empleados');
    }
}
