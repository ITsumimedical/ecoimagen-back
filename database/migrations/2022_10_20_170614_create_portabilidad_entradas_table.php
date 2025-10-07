<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePortabilidadEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portabilidad_entradas', function (Blueprint $table) {
            $table->id();
            $table->string('origen_ips');
            $table->string('telefono_ips')->nullable();
            $table->string('correo_ips')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->foreignId('estado_id')->default(1)->constrained('estados');
            $table->foreignId('user_id')->constrained('users');

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
        Schema::dropIfExists('portabilidad_entradas');
    }
}
