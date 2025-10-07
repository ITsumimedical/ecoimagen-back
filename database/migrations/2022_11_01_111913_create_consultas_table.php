<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->string('finalidad')->nullable();
            $table->dateTime('fecha_hora_inicio')->nullable();
            $table->dateTime('fecha_hora_final')->nullable();
            $table->foreignId('agenda_id')->nullable()->constrained('agendas');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('cup_id')->nullable()->constrained('cups');
            $table->foreignId('estado_id')->default(3)->constrained('estados');
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
        Schema::dropIfExists('consultas');
    }
}
