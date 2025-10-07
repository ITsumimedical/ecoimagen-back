<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesaAyudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesa_ayudas', function (Blueprint $table) {
            $table->id();
            $table->string('asunto', 2500);
            $table->string('descripcion', 2500);
            $table->integer('usuario_registra_id');
            $table->string('plataforma')->nullable();
            $table->foreignId('categoria_mesa_ayuda_id')->nullable()->constrained('categoria_mesa_ayudas');
            $table->foreignId('prioridad_id')->constrained('prioridades');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->foreignId('estado_id')->default(10)->constrained('estados');
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
        Schema::dropIfExists('mesa_ayudas');
    }
}
